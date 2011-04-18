<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel {
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;
    
    /**
     * Initializes this model.
     */
    public function init() {
        if (!Yii::app()->user->getIsGuest()) {
            $this->name = Yii::app()->user->name;
            $this->email = Yii::app()->user->email;
        }
    }

	/**
	 * Declares the validation rules.
	 */
	public function rules() {
		return array(
			// name, email, subject and body are required
			array('name, email, subject, body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
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
			'verifyCode'=>'Verification Code',
		);
	}
    
    /**
     * Formats all internal attribute as text.
     * Any HTML tags will be encoded.
     * New lines will be replaced by <br />.     
     */
    public function formatAttributes() {
        $formatter = Yii::app()->format;
        $attributes = $this->getAttributes();
        foreach($attributes as $attributeName=>$attributeValue) {
            $this->$attributeName = $formatter->formatNtext($attributeValue);
        }
        return $this;
    }
}