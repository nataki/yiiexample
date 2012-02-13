<?php

/**
 * UserIdentityDb represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * This class uses the database as a source of the user identity.
 * This class relies on {@link CActiveRecord} model: {@link User}.
 */
abstract class UserIdentityDb extends CUserIdentity {
	const ERROR_USER_INACTIVE = 3; // Inactive account

    /**
     * @var string class name of the model, which should be used by default,
     * if it can be retrieved from the web user.
     */
    protected $_defaultModelClassName = 'User';

    /**
	 * Authenticates a user, using {@link User} model.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
        $user = $this->findUserModel();
        if (empty($user)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = Yii::t('auth', 'Such username is not registered.');
        } else {
            $this->setState('id', $user->id);
            if ( strcmp($user->status_id,User::STATUS_ACTIVE)!==0 ) {
                $this->errorCode = self::ERROR_USER_INACTIVE;
                $this->errorMessage = Yii::t('auth', 'This account is inactive.');
            } elseif ( strcmp($user->password,$user->encryptPassword($this->password))!==0 ) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                $this->errorMessage = Yii::t('auth', 'Invalid password.');
            } else {
                $attributes = $user->getAttributes();
                foreach($attributes as $attributeName => $attributeValue) {
                    $this->setState($attributeName, $attributeValue);
                }
                $this->errorCode = self::ERROR_NONE;
                $this->errorMessage = '';
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
            $modelClassName = $this->_defaultModelClassName;
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