<?php
 
/**
 * Test case for the extension "ext.qs.lib.files.convert.QsFileConvertor".
 * @see QsFileConvertor
 */
class QsFileConvertorTest extends CTestCase {
	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.files.convert.*');
	}

	/**
	 * Creates the test file convertor instance.
	 * @return QsFileConvertor file convertor instance
	 */
	protected function createFileConvertor() {
		$methods = array(
			'convert',
			'getFileInfo',
		);
		return $this->getMock('QsFileConvertor', $methods);
	}

	public function testSetGet() {
		$fileConvertor = $this->createFileConvertor();

		$testDefaultOptions = array(
			'testName1' => 'testValue1',
			'testName2' => 'testValue2',
		);
		$this->assertTrue($fileConvertor->setDefaultOptions($testDefaultOptions), 'Unable to set default options!');
		$this->assertEquals($fileConvertor->getDefaultOptions(), $testDefaultOptions, 'Unable to set default options correctly!');
	}
}
