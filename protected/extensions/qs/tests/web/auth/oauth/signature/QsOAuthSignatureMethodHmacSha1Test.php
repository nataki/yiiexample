<?php

Yii::import('ext.qs.lib.web.auth.oauth.*');
Yii::import('ext.qs.lib.web.auth.oauth.signature.*');

/**
 * Test case for the extension "ext.qs.lib.web.auth.oauth.signature.QsOAuthSignatureMethodHmacSha1".
 * @see QsOAuthSignatureMethodHmacSha1
 */
class QsOAuthSignatureMethodHmacSha1Test extends CTestCase {
	public function testGenerateSignature() {
		$signatureMethod = new QsOAuthSignatureMethodHmacSha1();

		$baseString = 'test_base_string';
		$key = 'test_key';

		$signature = $signatureMethod->generateSignature($baseString, $key);
		$this->assertNotEmpty($signature, 'Unable to generate signature!');
	}
}
