<?php

/**
 * LoginFormAdmin is a login model for the
 * administration web application.
 */
class LoginFormAdmin extends LoginFormBase {
	/**
	 * Initializes this model.
	 */
	public function init() {
		parent::init();
		$this->_identityClassName = 'UserIdentityAdmin';
	}
}
