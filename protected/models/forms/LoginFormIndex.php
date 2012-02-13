<?php
 
/**
 * LoginFormIndex is a login model for the
 * main web application.
 */
class LoginFormIndex extends LoginFormBase {
    /**
	 * Initializes this model.
	 */
    public function init() {
        parent::init();
        $this->_identityClassName = 'UserIdentityIndex';
    }
}
