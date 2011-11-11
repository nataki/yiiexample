<?php

/**
 * SignupForm class.
 * SignupForm is the data structure for keeping signup form data.
 * This model creates new user account and sent email notification to its owner.
 * @see Member
 */
class SignupForm extends CFormModel {
    public $name;
    public $email;
    
    public $first_name;
    public $last_name;
    
    public $new_password;
    public $new_password_repeat;
    
    public $verifyCode;
    
    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('name, email, new_password, new_password_repeat', 'required'),
            array('first_name, last_name', 'required'),
            
            array('name, email, new_password, new_password_repeat', 'length', 'max'=>255),
            array('first_name, last_name', 'length', 'max'=>255),
            
            array('email','email'),
            array('new_password', 'compare', 'compareAttribute'=>'new_password_repeat'),
            array('name,email','unique','className'=>'User','attributeName'=>'name','caseSensitive'=>false),
            array('name,email','unique','className'=>'User','attributeName'=>'email','caseSensitive'=>false),
            
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty'=>( !Yii::app()->user->getIsGuest() || !CCaptcha::checkRequirements() ) ),
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
            'verifyCode'=>'Verification Code',
        );        
    }
    
    /**
     * Saves new user account.
     * @param boolean $runValidation whether to perform validation before saving new account.
     * @return CActiveRecord new user model, false - if fails.
     */
    public function save($runValidation=true) {
        if ( !$runValidation || $this->validate() ) {
            $user = $this->newUserModel();            
            $user = $this->applyUserModelAttributes($user);
            $user->save(false);
            $this->sendConfirmationEmail($user);
            return $user;
        } else {
            return false;
        }
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
     * @param CActiveRecord user model.
     * @return CActiveRecord user model.
     */
    protected function applyUserModelAttributes(CActiveRecord $user) {
        $excludedAttributeNames = array(
            'verifyCode'
        );
        foreach( $this->getAttributes() as $attributeName => $attributeValue ) {
            if ( array_search($attributeName, $excludedAttributeNames, true) !== false ) {
                continue;
            }
            $user->$attributeName = $attributeValue;
        }
        return $user;
    }
    
    /**
     * Send email confirmation
     * @return boolean success.
     */
    protected function sendConfirmationEmail(CActiveRecord $user) {
        $data = array(
            'member'=>$user
        );
        $emailMessage = Yii::app()->email->createEmailByPattern('signup', $data);
        $emailMessage->setTo($user->email);
        return $emailMessage->send();
    }
}