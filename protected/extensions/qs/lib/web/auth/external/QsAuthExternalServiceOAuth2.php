<?php
/**
 * QsAuthExternalServiceOAuth2 class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2013 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

/**
 * QsAuthExternalServiceOAuth2 is a base class for all OAuth/2.0 external auth services.
 * @see QsOAuthClient2
 *
 * @property QsOAuthClient2 $oauthClient public alias of {@link _oauthClient}.
 * @method QsOAuthClient2 getOauthClient()
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.web.auth.external
 */
abstract class QsAuthExternalServiceOAuth2 extends QsAuthExternalServiceOAuth {
	/**
	 * Returns default OAuth client class name.
	 * @return string OAuth client class name.
	 */
	protected function defaultOAuthClientClassName() {
		return 'QsOAuthClient2';
	}

	/**
	 * Authenticate the user.
	 * @return boolean whether user was successfully authenticated.
	 */
	public function authenticate() {
		/* @var $httpRequest CHttpRequest */
		$httpRequest = Yii::app()->getComponent('request');
		$oauthClient = $this->getOauthClient();

		// user denied error
		if (isset($_GET['error']) && $_GET['error'] == 'access_denied') {
			$this->redirectCancel();
			return false;
		}

		// Get the access_token and save them to the session.
		if (isset($_GET['code'])) {
			$code = $_GET['code'];
			$token = $oauthClient->fetchAccessToken($code);
			if (!empty($token)) {
				$this->isAuthenticated = true;
			}
		} else {
			$url = $oauthClient->buildAuthUrl();
			$httpRequest->redirect($url);
		}

		return $this->isAuthenticated;
	}
}
