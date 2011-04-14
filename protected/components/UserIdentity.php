<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
        $attributes = array(
            'name' => $this->username,
            'password' => sha1($this->password),
            'status_id' => User::STATUS_ACTIVE
        );
        $user = User::model()->findByAttributes($attributes);
        
        if (empty($user)) {
            $attributes = array(
                'name' => $this->username                
            );
            $user = User::model()->findByAttributes($attributes);
            if (empty($user)) {
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            } else {
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
        } else {
            $attributes = $user->getAttributes();
            foreach($attributes as $attributeName => $attributeValue) {
                $this->setState($attributeName, $attributeValue);
            }
            $this->errorCode=self::ERROR_NONE;
        }        
        return !$this->errorCode;
	}
    
    /**
     * Overload parent method {@link CUserIdentity::getId} to return id table field instead of username.
     */
    public function getId() {
        return $this->getState('id');
    }
}