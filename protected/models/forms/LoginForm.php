<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {
	public $username;
	public $password;
	public $rememberMe;

	protected $_identity;

    /**
     * Returns a list of behaviors that this model should behave as.
     * @return array the behavior configurations (behavior name=>behavior configuration).
     */
    public function behaviors() {
		return array(
            'authLogBehavior' => array(
                'class'=>'ext.qs.auth.QsModelBehaviorAuthLogDb',
            ),
        );
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
			'username'=>'Username or email',
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
     * @param string $attribute validated attribute name.
     * @param array $params validation parameters.
	 */
	public function authenticate($attribute,$params) {
		$this->_identity = new UserIdentity($this->username,$this->password);
		if (!$this->_identity->authenticate()) {
			$this->addError('password','Incorrect username or password.');
            /*if (!empty($this->_identity->errorMessage)) {
                $this->addError('password',$this->_identity->errorMessage);
            } else {
                $this->addError('password','Incorrect username or password.');
            }*/
        }
        $this->writeAuthLogFromUserIdentity($this->_identity);
	}

	/**
	 * Logs in the user using the given username and password in the model.
     * @param boolean $runValidation whether to perform validation before saving the record.
	 * @return boolean whether login is successful
	 */
	public function login($runValidation=true) {
		if (!$runValidation || $this->validate()) {
            if ($this->_identity===null) {
                $this->_identity = new UserIdentity($this->username,$this->password);
                $this->_identity->authenticate();
            }
            if ($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
                $duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
                Yii::app()->user->login($this->_identity,$duration);
                return true;
            }
        }
        return false;
	}        
}
