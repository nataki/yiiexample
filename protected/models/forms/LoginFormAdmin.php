<?php

/**
 * LoginFormAdmin is a login model for the
 * administration web application.
 */
class LoginFormAdmin extends LoginFormBase {
    public $verifyCode;

    /**
	 * Initializes this model.
	 */
    public function init() {
        parent::init();
    }

    /**
	 * Declares the validation rules.
     * @return array validation rules.
	 */
	public function rules() {
        $rules = parent::rules();
        if ( CCaptcha::checkRequirements()) {
            // verifyCode required
            $rules[] = array('verifyCode', 'required');
            // verifyCode needs to be entered correctly
            $rules[] = array('verifyCode', 'captcha');
        }
        return $rules;
    }
}
