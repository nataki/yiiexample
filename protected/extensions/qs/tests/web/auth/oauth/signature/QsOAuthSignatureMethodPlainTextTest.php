<?php

Yii::import('ext.qs.lib.web.auth.oauth.*');
Yii::import('ext.qs.lib.web.auth.oauth.signature.*');

/**
 * Test case for the extension "ext.qs.lib.web.auth.oauth.signature.QsOAuthSignatureMethodPlainText".
 * @see QsOAuthSignatureMethodPlainText
 */
class QsOAuthSignatureMethodPlainTextTest extends CTestCase {
	public function testGenerateSignature() {
		$signatureMethod = new QsOAuthSignatureMethodPlainText();

		$baseString = 'test_base_string';
		$key = 'test_key';

		$signature = $signatureMethod->generateSignature($baseString, $key);
		$this->assertNotEmpty($signature, 'Unable to generate signature!');
	}
}
