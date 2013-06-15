<?php

/**
 * LoginExternalService performs user login via external service account.
 */
class LoginExternalService extends CModel {
	/**
	 * @var string active record class, which should be used to retrieve the user.
	 */
	public $userModelClassName = 'Member';
	/**
	 * @var string model class which handles creation of new user account.
	 */
	public $newUserModelClassName = 'SignupForm';
	/**
	 * @var string new user model scenario, which should be used while creating
	 * new {@link newUserModelClassName} instance.
	 */
	public $newUserModelScenario = 'external';
	/**
	 * @var string active record class, which stores user external account information.
	 */
	public $userExternalAccountModelClassName = 'UserExternalAccount';
	/**
	 * @var QsAuthExternalUserIdentity user identity.
	 */
	protected $_userIdentity;

	// Attributes :

	/**
	 * @var string user external ID.
	 */
	public $id;
	/**
	 * @var string user email.
	 */
	public $email;

	/**
	 * @param QsAuthExternalUserIdentity $userIdentity user identity.
	 * @return LoginExternalService self instance.
	 * @throws CException on error.
	 */
	public function setUserIdentity($userIdentity) {
		if (!is_object($userIdentity)) {
			throw new CException('"' . get_class($this) . '::userIdentity" should be instance of "QsAuthExternalUserIdentity", "' . gettype($userIdentity) . '" given.');
		}
		$this->_userIdentity = $userIdentity;
		$userAttributes = $userIdentity->getPersistentStates();
		$this->setAttributes($userAttributes);
		if (!$this->validate()) {
			throw new CException("Invalid auth attributes:\n" . $this->composeModelErrorSummary($this));
		}
		return $this;
	}

	/**
	 * @return QsAuthExternalUserIdentity  user identity.
	 * @throws CException on error.
	 */
	public function getUserIdentity() {
		if (!is_object($this->_userIdentity)) {
			throw new CException('"' . get_class($this) . '::userIdentity" is not set.');
		}
		return $this->_userIdentity;
	}

	/**
	 * Returns the list of attribute names of the model.
	 * @return array list of attribute names.
	 */
	public function attributeNames() {
		return array(
			'id',
			'email',
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('id', 'required'),
			array('email', 'safe'),
			array('email', 'email'),
		);
	}

	/**
	 * Attempts to login user via external auth service identity.
	 * This method will succeed only if matching user already exist in the system.
	 * @throws CException on error.
	 * @return boolean success.
	 */
	public function login() {
		$userIdentity = $this->getUserIdentity();
		$externalService = $userIdentity->getService();

		$userExternalAccount = $this->findUserExternalAccount($externalService);
		if (empty($userExternalAccount)) {
			if (empty($this->email)) {
				return false;
			} else {
				$user = $this->findUserByEmail($this->email);
				if (!empty($user)) {
					$this->createUserExternalAccount($externalService, $user->getPrimaryKey());
				}
			}
		} else {
			$user = CActiveRecord::model($this->userModelClassName)->findByPk($userExternalAccount->user_id);
		}

		if (empty($user)) {
			return false;
		} else {
			return $this->loginUserModel($user);
		}
	}

	/**
	 * Login user by given model.
	 * @param CModel $userModel user model
	 * @return boolean success.
	 */
	public function loginUserModel(CModel $userModel) {
		$userIdentity = $this->getUserIdentity();
		$attributes = $userModel->getAttributes();
		foreach ($attributes as $attributeName => $attributeValue) {
			$userIdentity->setState($attributeName, $attributeValue);
		}
		$duration = 0;
		return Yii::app()->getComponent('user')->login($userIdentity, $duration);
	}

	/**
	 * @return CModel new user model.
	 */
	public function createNewUserModel() {
		$userIdentity = $this->getUserIdentity();
		$userAttributes = $userIdentity->getPersistentStates();
		$model = $this->createNewUserModelByAttributes($userAttributes);
		return $model;
	}

	/**
	 * Finds user external account model.
	 * @param QsAuthExternalService $externalService external auth service.
	 * @return CActiveRecord|null user external account model.
	 */
	protected function findUserExternalAccount($externalService) {
		$attributes = array(
			'external_user_id' => $this->id,
			'external_service_name' => $externalService->getName(),
		);
		return CActiveRecord::model($this->userExternalAccountModelClassName)->findByAttributes($attributes);
	}

	/**
	 * Finds user model.
	 * @param integer $userId user ID.
	 * @return CActiveRecord|null user model.
	 */
	protected function findUserByPk($userId) {
		return CActiveRecord::model($this->userModelClassName)->findByPk($userId);
	}

	/**
	 * Finds user model.
	 * @param string $userEmail user email address.
	 * @return CActiveRecord|null user model.
	 */
	protected function findUserByEmail($userEmail) {
		$attributes = array(
			'email' => $userEmail
		);
		return CActiveRecord::model($this->userModelClassName)->findByAttributes($attributes);
	}

	/**
	 * Creates new user external service account.
	 * @param QsAuthExternalService $externalService external auth service.
	 * @param integer $userId user id.
	 * @return CActiveRecord user external service account model.
	 */
	protected function createUserExternalAccount($externalService, $userId) {
		/* @var $model CActiveRecord */
		$className = $this->userExternalAccountModelClassName;
		$model = new $className;
		$attributes = array(
			'external_user_id' => $this->id,
			'external_service_name' => $externalService->getName(),
			'user_id' => $userId
		);
		$model->setAttributes($attributes, false);
		$model->save(false);
		return $model;
	}

	/**
	 * @param CActiveRecord $user
	 * @param CActiveRecord $userExternalAccount
	 * @return boolean success.
	 */
	protected function bindUserExternalAccount($user, $userExternalAccount) {
		$userExternalAccount->user_id = $user->id;
		return $userExternalAccount->save(false);
	}

	/**
	 * Creates new user model filling it up with given attributes.
	 * @param array $externalUserAttributes new user attributes
	 * @return CModel new uer model.
	 */
	protected function createNewUserModelByAttributes(array $externalUserAttributes) {
		/* @var $model CModel */
		$className = $this->newUserModelClassName;
		$model = new $className();
		$model->setScenario($this->newUserModelScenario);
		$password = sha1(uniqid($this->id, true));
		$attributes = array_merge(
			$externalUserAttributes,
			array(
				'name' => $this->email,
				'email' => $this->email,
				'new_password' => $password,
				'new_password_repeat' => $password,
			)
		);
		$model->setAttributes($attributes);
		return $model;
	}

	protected function composeModelErrorSummary(CModel $model) {
		$errorSummaryParts = array();
		$errors = $model->getErrors();
		foreach ($errors as $attributeErrors) {
			$errorSummaryParts = array_merge($errorSummaryParts, $attributeErrors);
		}
		$errorSummary = implode("\n", $errorSummaryParts);
		return $errorSummary;
	}
}
