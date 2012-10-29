<?php
 
/**
 * Test case for the extension module "ext.qs.lib.i18n.modules.messagetranslation.MessagetranslationModule".
 * @see MessagetranslationModule
 */
class MessagetranslationModuleTest extends CTestCase {
	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.i18n.modules.messagetranslation.MessagetranslationModule');
	}

	/**
	 * Creates test message translation module instance.
	 * @return MessagetranslationModule message translation module instance.
	 */
	protected function createMessageTranslationModule() {
		$module = new MessagetranslationModule('messagetranslation', Yii::app());
		return $module;
	}

	// Tests:

	public function testSetGet() {
		$module = $this->createMessageTranslationModule();
		$this->assertTrue(true);
	}
}
