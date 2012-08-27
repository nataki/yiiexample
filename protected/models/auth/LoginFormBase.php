<?php

/**
 * LoginFormBase is a base class for login forms.
 * LoginFormBase is the data structure for keeping
 * user login form data.
 */
abstract class LoginFormBase extends CFormModel {
	/**
	 * @var string user identity class name.
	 */
	protected $_identityClassName = 'UserIdentity';
	/**
	 * @var CUserIdentity user identity instance.
	 */
	protected $_identity;
	/**
	 * @var boolean indicates if {@link CUserIdentity::errorMessage} should be displayed
	 * to the user if authentication failed.
	 */
	protected $_useIdentityErrorMessage = false;
	/**
	 * @var boolean indicates if captcha verification should be append to the model.
	 */
	protected $_isCaptchaRequired = null;

	// Attributes:
	public $username;
	public $password;
	public $rememberMe;
	public $verifyCode;

	// Set / Get :

	public function setIsCaptchaRequired($isCaptchaRequired) {
		$this->_isCaptchaRequired = $isCaptchaRequired;
		return true;
	}

	public function getIsCaptchaRequired() {
		if ($this->_isCaptchaRequired === null) {
			$this->initIsCaptchaRequired();
		}
		return $this->_isCaptchaRequired;
	}

	/**
	 * Initializes the {@link isCaptchaRequired} value, based on data
	 * from {@link AuthLog}.
	 * @return boolean success.
	 */
	protected function initIsCaptchaRequired() {
		$isCaptchaRequired = false;
		if (CCaptcha::checkRequirements()) {
			$criteria = array(
				'condition'=>'username = :username',
				'order'=>'date DESC',
				'limit'=>2,
				'params'=>array(
					'username'=>$this->username
				)
			);
			$authLogs = AuthLog::model()->findAll($criteria);
			if ( is_array($authLogs) && !empty($authLogs) ) {
				$isCaptchaRequired = true;
				foreach ($authLogs as $authLog) {
					if ($authLog->getIsSuccessful()) {
						$isCaptchaRequired = false;
						break;
					}
				}
			}
		}
		$this->_isCaptchaRequired = $isCaptchaRequired;
		return true;
	}

	/**
	 * Creates user identity instance, according to {@link identityClassName} value.
	 * @return CUserIdentity user identity.
	 */
	protected function createIdentity() {
		$className = $this->_identityClassName;
		$identity = new $className($this->username,$this->password);
		return $identity;
	}

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 * @return array validation rules.
	 */
	public function rules() {
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// perform captcha validation if it is necessary
			array('verifyCode', 'validateCaptcha'),
			// password needs to be authenticated
			array('password', 'authenticate', 'skipOnError'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 * @return array attribute label names.
	 */
	public function attributeLabels() {
		return array(
			'username'=>Yii::t('auth', 'Username or email'),
			'password'=>Yii::t('auth', 'Password'),
			'rememberMe'=>Yii::t('auth', 'Remember me next time'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 * @param string $attribute validated attribute name.
	 * @param array $params validation parameters.
	 */
	public function authenticate($attribute,$params) {
		$this->_identity = $this->createIdentity();
		if (!$this->_identity->authenticate()) {
			if ( $this->_useIdentityErrorMessage && !empty($this->_identity->errorMessage) ) {
				$this->addError($attribute,$this->_identity->errorMessage);
			} else {
				$defaultErrorMessage = Yii::t('auth', 'Incorrect username or password.');
				$this->addError($attribute,$defaultErrorMessage);
			}
			// Log auth error:
			Yii::app()->user->writeAuthLogFromUserIdentity($this->_identity);
		}
	}

	/**
	 * Performs the captcha validation if {@link isCaptchaRequired} is true.
	 * @param string $attribute validated attribute name.
	 * @param array $params validation parameters.
	 */
	public function validateCaptcha($attribute,$params) {
		if ($this->getIsCaptchaRequired()) {
			$captchaValidator = CValidator::createValidator('captcha',$this,$attribute,$params);
			$captchaValidator->validate($this);
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @param boolean $runValidation whether to perform validation before saving the record.
	 * @return boolean whether login is successful
	 */
	public function login($runValidation=true) {
		if (!$runValidation || $this->validate()) {
			if ($this->_identity===null) {
				$this->_identity = $this->createIdentity();
				$this->_identity->authenticate();
			}
			if ($this->_identity->errorCode===CBaseUserIdentity::ERROR_NONE) {
				$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($this->_identity,$duration);
				return true;
			}
		}
		return false;
	}
}
