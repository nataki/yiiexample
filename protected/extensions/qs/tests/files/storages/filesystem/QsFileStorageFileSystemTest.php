<?php

/**
 * Test case for the extension "ext.qs.lib.files.storages.filesystem.QsFileStorageFileSystem".
 * @see QsFileStorageFileSystem
 */
class QsFileStorageFileSystemTest extends CTestCase {

	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.files.storages.*');
		Yii::import('ext.qs.lib.files.storages.filesystem.*');
	}

	public function testSetGet() {
		$fileStorage = Yii::createComponent('QsFileStorageFileSystem');

		$testBasePath = '/test/base/path';
		$this->assertTrue($fileStorage->setBasePath($testBasePath), 'Unable to set base path!');
		$this->assertEquals($fileStorage->getBasePath(), $testBasePath, 'Unable to set base path correctly!');

		$testBaseUrl = 'http://test/base/url';
		$this->assertTrue($fileStorage->setBaseUrl($testBaseUrl), 'Unable to set base URL!');
		$this->assertEquals($fileStorage->getBaseUrl(), $testBaseUrl, 'Unable to set base URL correctly!');

		$testFilePermission = rand(1,100);
		$this->assertTrue($fileStorage->setFilePermission($testFilePermission), 'Unable to set file permission!');
		$this->assertEquals($fileStorage->getFilePermission(), $testFilePermission, 'Unable to set file permission correctly!');
	}
}
