<?php
 
/**
 * Test case for the extension "ext.qs.lib.files.storages.QsFileStorageBucketSubDirTemplate".
 * @see QsFileStorageBucketSubDirTemplate
 */
class QsFileStorageBucketSubDirTemplateTest extends CTestCase {
	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.files.storages.*');
	}

	/**
	 * Get file storage bucket mock object.
	 * @return QsFileStorageBucketSubDirTemplate file storage bucket instance.
	 */
	protected function createFileStorageBucket() {
		$methodsList = array(
			'create',
			'destroy',
			'exists',
			'saveFileContent',
			'getFileContent',
			'deleteFile',
			'fileExists',
			'copyFileIn',
			'copyFileOut',
			'copyFileInternal',
			'moveFileIn',
			'moveFileOut',
			'moveFileInternal',
			'getFileUrl',
		);
		$bucket = $this->getMock('QsFileStorageBucketSubDirTemplate',$methodsList);
		return $bucket;
	}

	public function testSetGet() {
		$bucket = $this->createFileStorageBucket();

		$testFileSubDirTemplate = 'test/file/subdir/template';
		$this->assertTrue( $bucket->setFileSubDirTemplate($testFileSubDirTemplate), 'Unable to set file sub dir template!' );
		$this->assertEquals( $bucket->getFileSubDirTemplate(), $testFileSubDirTemplate, 'Unable to set file sub dir template correctly!' );
	}
}
