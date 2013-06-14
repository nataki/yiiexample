<?php

/**
 * LoginExternalService
 */
class LoginExternalService extends CModel {
	public $userModelClassName = 'Member';
	public $userExternalAccountModelClassName = 'UserExternalAccount';

	public $id;
	public $email;

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
			array('id, email', 'required'),
			array('email', 'email'),
		);
	}

	/**
	 * @param QsAuthExternalUserIdentity $userIdentity
	 * @throws CException
	 * @return boolean success.
	 */
	public function login($userIdentity) {
		$userAttributes = $userIdentity->getPersistentStates();
		$this->setAttributes($userAttributes);
		if (!$this->validate()) {
			throw new CException('Invalid auth attributes.');
		}
		$externalService = $userIdentity->getService();

		$userExternalAccount = $this->findUserExternalAccount($externalService);
		if (empty($userExternalAccount)) {
			$userExternalAccount = $this->createUserExternalAccount($externalService);
		}
		if (!empty($userExternalAccount->user_id)) {
			$user = CActiveRecord::model($this->userModelClassName)->findByPk($userExternalAccount->user_id);
		}
		if (empty($user)) {
			$user = CActiveRecord::model($this->userModelClassName)->findByAttributes(array('email' => $this->email));
			if (empty($user)) {
				$user = $this->createUser($userAttributes);
			}
			$this->bindUserExternalAccount($user, $userExternalAccount);
		}

		$attributes = $user->getAttributes();
		foreach ($attributes as $attributeName => $attributeValue) {
			$userIdentity->setState($attributeName, $attributeValue);
		}

		$duration = 0;
		Yii::app()->getComponent('user')->login($userIdentity, $duration);
		return true;
	}


	/**
	 * @param QsAuthExternalService $externalService
	 * @return CActiveRecord|null
	 */
	protected function findUserExternalAccount($externalService) {
		$attributes = array(
			'external_user_id' => $this->id,
			'external_service_name' => $externalService->getName(),
		);
		return CActiveRecord::model($this->userExternalAccountModelClassName)->findByAttributes($attributes);
	}

	/**
	 * @param QsAuthExternalService $externalService
	 * @return CActiveRecord
	 */
	protected function createUserExternalAccount($externalService) {
		/* @var $model CActiveRecord */
		$className = $this->userExternalAccountModelClassName;
		$model = new $className;
		$attributes = array(
			'external_user_id' => $this->id,
			'external_service_name' => $externalService->getName(),
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

	protected function createUser(array $externalUserAttributes) {
		/* @var $model CActiveRecord */
		$className = $this->userModelClassName;
		$model = new $className;
		$password = sha1(uniqid($this->email, true));
		$attributes = array_merge(
			$externalUserAttributes,
			array(
				'name' => $this->email,
				'email' => $this->email,
				'new_password' => $password,
				'new_password_repeat' => $password,
			)
		);
		$specialUserAttributes = array(
			'id',
			'status_id',
			'group_id',
			'create_date',
		);
		foreach ($specialUserAttributes as $attributeName) {
			unset($attributes[$attributeName]);
		}

		foreach ($attributes as $name => $value) {
			try {
				$model->$name = $value;
			} catch (CException $e) {
				// suppress missing property exception
			}
		}

		if (!$model->save()) {
			throw new CException("Unable to create new user:\n" . $this->composeModelErrorSummary($model));
		}
		return $model;
	}

	protected function composeModelErrorSummary(CModel $model) {
		$errorSummaryParts = array();
		$errors = $model->getErrors();
		foreach ($errors as $attributeName => $attributeErrors) {
			$errorSummaryParts = array_merge($errorSummaryParts, $attributeErrors);
		}
		$errorSummary = implode("\n", $errorSummaryParts);
		return $errorSummary;
	}
}
