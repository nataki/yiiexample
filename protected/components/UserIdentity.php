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
            'password' => $this->password
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
            $this->setState('email', $user->email);
            $this->setState('create_date', $user->create_date);
            $this->setState('group_id', $user->group_id);
            $this->errorCode=self::ERROR_NONE;
        }        
        return !$this->errorCode;
	}
}