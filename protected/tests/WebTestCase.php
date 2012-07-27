<?php

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
//define('TEST_BASE_URL','http://localhost/myproject/index-test.php/');

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase {
	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp() {
		parent::setUp();
		//$this->setBrowserUrl(TEST_BASE_URL);
		$rootUrl = Yii::app()->createAbsoluteUrl('/');
		$this->setBrowserUrl($rootUrl);
	}

	/**
	 * Returns the current emulated user session data from the server.
	 * @return array user session data.
	 */
	protected function getUserSessionData() {
		$session = Yii::app()->session;
		$sessionId = $this->getCookieByName( $session->getSessionName() );
		$session->setSessionId($sessionId);
		$session->open();
		$result = $_SESSION;
		$session->close();
		return $result;
	}

	/**
	 * Determines the captcha verification code from the session.
	 * @return string captcha verification code.
	 */
	protected function getCaptchaCode() {
		$captchaVerifyCode = '';
		foreach($this->getUserSessionData() as $varName => $varValue) {
			if (preg_match('/^(Yii\.CCaptchaAction)(.*)(captcha)$/s', $varName)) {
				$captchaVerifyCode = $varValue;
				break;
			}
		}
		return $captchaVerifyCode;
	}
}
