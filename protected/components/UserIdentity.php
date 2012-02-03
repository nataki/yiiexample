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
        $user = $this->findUserModel();
        if (empty($user)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if( strcmp($user->status_id,User::STATUS_ACTIVE)!==0 ) {
                $this->errorCode = self::ERROR_USER_INACTIVE;
            } elseif ( strcmp($user->password,$user->encryptPassword($this->password))!==0 ) {
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
     * @return integer user id.
     */
    public function getId() {
        return $this->getState('id');
    }

    /**
     * Returns user active record model finder.
     * @return CActiveRecord user model finder.
     */
    protected function getUserModelFinder() {
        try {
            $webUser = Yii::app()->getComponent('user');
            $modelClassName = $webUser->modelClassName;
        } catch (CException $exception) {
            $modelClassName = 'User';
        }
        $userModelFinder = CActiveRecord::model($modelClassName);
        return $userModelFinder;
    }

    /**
     * Finds user record in the database, which corresponds current {@link username} value.
     * @return CActiveRecord user model.
     */
    protected function findUserModel() {
        $userModelFinder = $this->getUserModelFinder();
        $userTableAlias = $userModelFinder->getTableAlias();
        $userModel = $userModelFinder->find("{$userTableAlias}.name=:username OR {$userTableAlias}.email=:username",array(':username'=>$this->username));
        return $userModel;
    }
}