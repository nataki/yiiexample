<?php

/**
 * SignupForm class.
 * SignupForm is the data structure for keeping signup form data.
 * This model creates new user account and sent email notification to its owner.
 * @see Member
 */
class SignupForm extends CFormModel {
	/**
	 * @var array user external account attributes.
	 */
	protected $_externalAttributes = array();

	// Attributes:

	public $name;
	public $email;

	public $first_name;
	public $last_name;

	public $new_password;
	public $new_password_repeat;

	public $verifyCode;

	/**
	 * Constructor.
	 * @param string $scenario name of the scenario that this model is used in.
	 */
	public function __construct($scenario = 'default') {
		parent::__construct($scenario);
	}

	/**
	 * @param array $externalAttributes user external account attributes.
	 * @return SignupForm self instance.
	 */
	public function setExternalAttributes(array $externalAttributes) {
		$this->_externalAttributes = $externalAttributes;
		return $this;
	}

	/**
	 * @return array user external account attributes.
	 */
	public function getExternalAttributes() {
		return $this->_externalAttributes;
	}

	/**
	 * Declares the validation rules.
	 * @return array validation rules.
	 */
	public function rules() {
		return array(
			array('name, email', 'required'),
			array('new_password, new_password_repeat', 'required', 'on'=>'default'),
			array('first_name, last_name', 'required'),

			array('name, email, new_password, new_password_repeat', 'length', 'max'=>255),
			array('first_name, last_name', 'length', 'max'=>255),

			array('email','email'),
			array('new_password', 'compare', 'compareAttribute'=>'new_password_repeat', 'on'=>'default'),
			array('name,email', 'unique', 'className'=>'User', 'attributeName'=>'name', 'caseSensitive'=>false),
			array('name,email', 'unique', 'className'=>'User', 'attributeName'=>'email', 'caseSensitive'=>false),

			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>(!Yii::app()->user->getIsGuest() || !CCaptcha::checkRequirements()), 'on'=>'default'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels() {
		return array(
			'name' => 'Username',
			'email' => 'Email',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'new_password' => 'Password',
			'new_password_repeat' => 'Password Repeat',
			'verifyCode' => 'Verification Code',
		);
	}

	/**
	 * Saves new user account.
	 * @param boolean $runValidation whether to perform validation before saving new account.
	 * @return CActiveRecord new user model, false - if fails.
	 */
	public function save($runValidation = true) {
		if (!$runValidation || $this->validate()) {
			switch ($this->getScenario()) {
				case 'external': {
					$user = $this->signUpExternal();
					break;
				}
				default: {
					$user = $this->signUpDefault();
					break;
				}
			}
			$this->sendConfirmationEmail($user);
			return $user;
		} else {
			return false;
		}
	}

	/**
	 * Performs user sign up by default scenario.
	 * @return CActiveRecord new user model.
	 */
	protected function signUpDefault() {
		$user = $this->newUserModel();
		$user = $this->applyUserModelAttributes($user);
		$user->save(false);
		return $user;
	}

	/**
	 * Performs user sign up by external auth service scenario.
	 * @throws CException on error.
	 * @return CActiveRecord new user model.
	 */
	protected function signUpExternal() {
		$user = $this->newUserModel();
		$externalAttributes = $this->getExternalAttributes();
		if (empty($externalAttributes)) {
			throw new CException('External auth service attributes are missing!');
		}
		$password = sha1(uniqid($externalAttributes['id'], true));
		$this->new_password = $password;
		$this->new_password_repeat = $password;
		$user = $this->applyUserModelAttributes($user);
		$user->save(false);
		$this->createUserExternalAccount($externalAttributes['id'], $externalAttributes['authServiceName'], $user->getPrimaryKey());
		return $user;
	}

	/**
	 * Creates new blank user model.
	 * @return CActiveRecord user model.
	 */
	protected function newUserModel() {
		$user = new Member();
		$user->status_id = User::STATUS_ACTIVE;
		return $user;
	}

	/**
	 * Fills the user model with the data from the form.
	 * @param CActiveRecord $user user model.
	 * @return CActiveRecord user model.
	 */
	protected function applyUserModelAttributes(CActiveRecord $user) {
		$excludedAttributeNames = array(
			'verifyCode'
		);
		foreach ($this->getAttributes() as $attributeName => $attributeValue) {
			if (array_search($attributeName, $excludedAttributeNames, true) !== false) {
				continue;
			}
			$user->$attributeName = $attributeValue;
		}
		return $user;
	}

	/**
	 * Creates new user external service account.
	 * @param string $externalUserId external user id.
	 * @param string $externalServiceName external auth service name.
	 * @param integer $userId user id.
	 * @return CActiveRecord user external service account model.
	 */
	protected function createUserExternalAccount($externalUserId, $externalServiceName, $userId) {
		$model = new UserExternalAccount();
		$attributes = array(
			'external_user_id' => $externalUserId,
			'external_service_name' => $externalServiceName,
			'user_id' => $userId
		);
		$model->setAttributes($attributes, false);
		$model->save(false);
		return $model;
	}

	/**
	 * Send email confirmation
	 * @param CActiveRecord $user user model.
	 * @return boolean success.
	 */
	protected function sendConfirmationEmail(CActiveRecord $user) {
		$data = array(
			'member' => $user
		);
		$emailMessage = Yii::app()->email->createEmailByPattern('signup', $data);
		$emailMessage->setTo($user->email);
		return $emailMessage->send();
	}
}