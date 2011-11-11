<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	const ERROR_USER_INACTIVE = 3;

    /**
	 * Authenticates a user, using {@link User} model.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
        $userFinder = User::model();
        $userTableAlias = $userFinder->getTableAlias();
        $user = $userFinder->find("{$userTableAlias}.name=:username OR {$userTableAlias}.email=:username",array(':username'=>$this->username));

        if (empty($user)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if( strcmp($user->status_id,User::STATUS_ACTIVE)!==0 ) {
                $this->errorCode = self::ERROR_USER_INACTIVE;
            } elseif ( strcmp($user->password,sha1($this->password))!==0 ) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $attributes = $user->getAttributes();
                foreach($attributes as $attributeName => $attributeValue) {
                    $this->setState($attributeName, $attributeValue);
                }
                $this->errorCode = self::ERROR_NONE;
            }
        }

        return !$this->errorCode;
	}
    
    /**
     * Overload parent method {@link CUserIdentity::getId} to return id table field instead of username.
     */
    public function getId() {
        return $this->getState('id');
    }
    
    /**
     * Logs successful login into database.
     * @param CEvent $event - event instance, which is risen from {@link QsWebUser}
     * @see QsWebUser::onAfterLogin
     */
    public static function logLogin(CEvent $event) {
        $webUser = $event->sender;
        
        $authLog = new AuthLog();
        $authLog->error_code = 0;
        $authLog->user_id = $webUser->getId();
        $authLog->username = $webUser->getState('name');
        return $authLog->save();
    }
    
    /**
     * Updates the state of the web user from the accounts storage. 
     * This method ensures user still exist and active.
     * @param CEvent $event - event instance, which is risen from {@link QsWebUser}
     * @see QsWebUser::onAfterRestore
     */
    public static function updateUserStates(CEvent $event) {
        $webUser = $event->sender;
        
        if (!$webUser->getIsGuest()) {
            $attributes = array(
                'id' => $webUser->getId(),
                'status_id' => User::STATUS_ACTIVE
            );
            $user = User::model()->findByAttributes($attributes);
            if (empty($user)) {
                $webUser->logout(false);
            } else {
                $userAttributes = $user->getAttributes();
                foreach($userAttributes as $name => $value) {
                    $webUser->setState($name, $value);
                }
            }
        }
    }
}