<?php
 
/**
 * Test case for the extension "ext.qs.lib.web.QsClientScript".
 * @see QsClientScript
 */
class QsClientScriptTest extends CTestCase {
	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.web.QsClientScript');
	}

	/**
	 * Creates test client script instance.
	 * @return QsClientScript test client script instance.
	 */
	protected function createTestClientScript() {
		$config = array(
			'class' => 'QsClientScript'
		);
		$clientScript = Yii::createComponent($config);
		$clientScript->init();
		return $clientScript;
	}

	// Tests:

	public function testRegisterMetaTag() {
		$clientScript = $this->createTestClientScript();

		$testMetaTagContent = 'test meta tag content';
		$testMetaTagName = 'test_meta_tag_name';

		$clientScript->registerMetaTag($testMetaTagContent, $testMetaTagName);

		$testOutput = '<head></head>';
		$clientScript->render($testOutput);

		$expectedMetaTagHtml = CHtml::metaTag($testMetaTagContent, $testMetaTagName);

		$this->assertContains($expectedMetaTagHtml, $testOutput, 'Unable to register meta tag!');
	}

	public function testRegisterMetaTagUnique() {
		$clientScript = $this->createTestClientScript();

		$testMetaTagContent = 'test meta tag content';
		$testMetaTagName = 'test_meta_tag_name';

		$clientScript->registerMetaTagUnique($testMetaTagContent, $testMetaTagName);

		$testOutput = '<head></head>';
		$clientScript->render($testOutput);

		$expectedMetaTagHtml = CHtml::metaTag($testMetaTagContent, $testMetaTagName);

		$this->assertContains($expectedMetaTagHtml, $testOutput, 'Unable to register meta tag unique!');
	}

	/**
	 * @depends testRegisterMetaTag
	 */
	public function testAppendMetaTag() {
		$clientScript = $this->createTestClientScript();

		$testMetaTagContent = 'test meta tag content';
		$testMetaTagName = 'test_meta_tag_name';
		$clientScript->registerMetaTag($testMetaTagContent, $testMetaTagName);

		$testMetaTagContentAppended = $testMetaTagContent.' appended';
		$clientScript->registerMetaTag($testMetaTagContentAppended, $testMetaTagName);

		$testOutput = '<head></head>';
		$clientScript->render($testOutput);

		$expectedMetaTagHtml = CHtml::metaTag($testMetaTagContent, $testMetaTagName);
		$expectedMetaTagHtmlAppended = CHtml::metaTag($testMetaTagContentAppended, $testMetaTagName);

		$this->assertContains($expectedMetaTagHtml, $testOutput, 'Unable to register original meta tag!');
		$this->assertContains($expectedMetaTagHtmlAppended, $testOutput, 'Unable to register additional meta tag!');
	}

	/**
	 * @depends testRegisterMetaTagUnique
	 */
	public function testOverrideMetaTag() {
		$clientScript = $this->createTestClientScript();

		$testMetaTagContent = 'test meta tag content';
		$testMetaTagName = 'test_meta_tag_name';
		$clientScript->registerMetaTagUnique($testMetaTagContent, $testMetaTagName);

		$testMetaTagContentOverridden = $testMetaTagContent.' overridden';
		$clientScript->registerMetaTagUnique($testMetaTagContentOverridden, $testMetaTagName);

		$testOutput = '<head></head>';
		$clientScript->render($testOutput);

		$expectedMetaTagHtml = CHtml::metaTag($testMetaTagContent, $testMetaTagName);
		$expectedMetaTagHtmlOverridden = CHtml::metaTag($testMetaTagContentOverridden, $testMetaTagName);

		$this->assertContains($expectedMetaTagHtmlOverridden, $testOutput, 'Unable to register meta tag, which overrides already existed!');
		$this->assertNotContains($expectedMetaTagHtml, $testOutput, 'Overridden meta tag has been rendered!');
	}
}
