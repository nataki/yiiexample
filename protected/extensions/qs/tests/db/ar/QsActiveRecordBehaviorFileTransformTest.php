<?php
 
/**
 * Test case for the extension "ext.qs.lib.db.ar.QsActiveRecordBehaviorFileTransform".
 * @see QsActiveRecordBehaviorFileTransform
 */
class QsActiveRecordBehaviorFileTransformTest extends CTestCase {
	/**
	 * @var IQsFileStorage application file storage component backup.
	 */
	protected static $_fileStorageBackup = null;

	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.db.ar.*');
		Yii::import('ext.qs.lib.files.storages.*');
		Yii::import('ext.qs.lib.files.storages.filesystem.*');

		// Database:
		$testTableName = self::getTestTableName();

		$dbSetUp = new QsTestDbMigration();
		$columns = array(
			'id' => 'pk',
			'name' => 'string',
			'file_extension' => 'string',
			'file_version' => 'integer',
		);
		$dbSetUp->createTable($testTableName, $columns);

		$activeRecordGenerator = new QsTestActiveRecordGenerator();
		$activeRecordGenerator->generate(
			array(
				'tableName' => $testTableName,
				'behaviors' => array(
					'fileTransformBehavior' => array(
						'class' => 'ext.qs.lib.db.ar.QsActiveRecordBehaviorFileTransform',
						'transformCallback' => 'copy',
						'fileTransforms' => array(
							'default' => null,
							'custom' => null
						),
					)
				),
			)
		);

		// File Storage:
		if (Yii::app()->hasComponent('fileStorage')) {
			self::$_fileStorageBackup = Yii::app()->getComponent('fileStorage');
		}
		$fileStorage = Yii::createComponent(self::createFileStorageConfig());
		Yii::app()->setComponent('fileStorage', $fileStorage);
	}

	public static function tearDownAfterClass() {
		// Database:
		$dbSetUp = new QsTestDbMigration();
		$dbSetUp->dropTable(self::getTestTableName());
		// File Storage:
		if (is_object(self::$_fileStorageBackup)) {
			Yii::app()->setComponent('fileStorage', self::$_fileStorageBackup);
		}
	}

	public function setUp() {
		$dbSetUp = new QsTestDbMigration();
		$testTableName = self::getTestTableName();
		$dbSetUp->truncateTable($testTableName);

		$columns = array(
			'name' => 'test_name',
		);
		$dbSetUp->insert($testTableName, $columns);

		$_FILES = array();
		CUploadedFile::reset();

		// Test source path:
		$testFileSourcePath = $this->getTestSourceBasePath();
		if (!file_exists($testFileSourcePath)) {
			mkdir($testFileSourcePath, 0777, true);
		}
	}

	public function tearDown() {
		$behaviorTempFilePath = Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'QsActiveRecordBehaviorFileTransform';
		$command = "rm -rf {$behaviorTempFilePath}";
		exec($command);

		$testFileSourcePath = $this->getTestSourceBasePath();
		$command = "rm -rf {$testFileSourcePath}";
		exec($command);

		$testFileStoragePath = self::getTestFileStorageBasePath();
		$command = "rm -rf {$testFileStoragePath}";
		exec($command);
	}

	/**
	 * Returns the name of the test table.
	 * @return string test table name.
	 */
	public static function getTestTableName() {
		return 'test_'.__CLASS__.'_'.getmypid();
	}

	/**
	 * Returns the name of the test active record class.
	 * @return string test active record class name.
	 */
	public static function getTestActiveRecordClassName() {
		return self::getTestTableName();
	}

	/**
	 * Returns the base path for the test files.
	 * @return string test file base path.
	 */
	protected function getTestSourceBasePath() {
		return Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.get_class($this).'_source';
	}

	/**
	 * Returns the base path for the test files.
	 * @return string test file base path.
	 */
	protected static function getTestFileStorageBasePath() {
		return Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.__CLASS__.'_fileStorage';
	}

	/**
	 * Returns the file storage component configuration.
	 * @return array file storage component config.
	 */
	protected static function createFileStorageConfig() {
		$fileStorageConfig = array(
			'class' => 'QsFileStorageFileSystem',
			'basePath' => self::getTestFileStorageBasePath(),
			'baseUrl' => 'http://www.mydomain.com/files',
			'filePermission' => 0777
		);
		return $fileStorageConfig;
	}

	/**
	 * Returns the test active record finder.
	 * @return CActiveRecord active record finder instance.
	 */
	protected function getActiveRecordFinder() {
		return CActiveRecord::model(self::getTestTableName());
	}

	/**
	 * Creates new test active record instance.
	 * @return CActiveRecord active record instance.
	 */
	protected function newActiveRecord() {
		$className = self::getTestTableName();
		$activeRecord = new $className();
		return $activeRecord;
	}

	/**
	 * Returns the test file path.
	 * @return string test file full name.
	 */
	protected function getTestFileFullName() {
		$fileFullName = dirname( Yii::getPathOfAlias('application') ).'/css/admin/bg.gif';
		return $fileFullName;
	}

	// Tests:

	public function testCreate() {
		$behavior = new QsActiveRecordBehaviorFileTransform();
		$this->assertTrue(is_object($behavior));
	}

	/**
	 * @depends testCreate
	 */
	public function testTransformCallbackSetUp() {
		$behavior = new QsActiveRecordBehaviorFileTransform();

		$testTransformCallBack = 'copy';
		$this->assertTrue($behavior->setTransformCallback($testTransformCallBack), 'Unable to set transform callback!');
		$this->assertEquals($behavior->getTransformCallback(), $testTransformCallBack, 'Unable to set transform callback correctly!');
	}

	/**
	 * @depends testCreate
	 */
	public function testDefaultFileUrlSetUp() {
		$behavior = new QsActiveRecordBehaviorFileTransform();

		$testDefaultFileUrl = 'http://default/file/web/src';
		$this->assertTrue($behavior->setDefaultFileUrl($testDefaultFileUrl), 'Unable to set default file URL!');
		$this->assertEquals($behavior->getDefaultFileUrl(), $testDefaultFileUrl, 'Unable to set default file URL correctly!');

		$testDefaultFileUrlArray = array(
			'name1' => 'http://default/file/web/src/1',
			'name2' => 'http://default/file/web/src/2',
		);
		$this->assertTrue($behavior->setDefaultFileUrl($testDefaultFileUrlArray), 'Unable to set default file URL with array!');
		//$this->assertEquals($behavior->getDefaultFileUrl(), $testDefaultFileUrlArray, 'Unable to set default file URL with array correctly!');
	}

	/**
	 * @depends testCreate
	 */
	public function testTransformSetUp() {
		$behavior = new QsActiveRecordBehaviorFileTransform();

		$testFileTransforms = array(
			'test' => array(
				'param_1' => 'value_1',
				'param_2' => 'value_2',
			),
		);
		$this->assertTrue($behavior->setFileTransforms($testFileTransforms), 'Unable to set file transforms!');
		$this->assertEquals($behavior->getFileTransforms(), $testFileTransforms, 'Unable to set file transforms correctly!');

		$testFileTransformName = 'test_file_name';
		$testFileTransform = array(
			'single_param_1' => 'single_value_1',
			'single_param_2' => 'single_value_2',
		);
		$this->assertTrue($behavior->addFileTransform($testFileTransformName, $testFileTransform), 'Unable to add file transform!');
		$this->assertEquals($behavior->getFileTransform($testFileTransformName), $testFileTransform, 'Unable to get single file transform!');
	}

	/**
	 * @depends testTransformCallbackSetUp
	 * @depends testTransformSetUp
	 */
	public function testSaveFile() {
		$activeRecordFinder = $this->getActiveRecordFinder();
		$fileTransforms = $activeRecordFinder->getFileTransforms();
		$this->assertFalse( empty($fileTransforms), 'Empty file sizes for the test active record class!');

		$activeRecord = $activeRecordFinder->find(null);

		$testFileName = $this->getTestFileFullName();
		$testFileExtension = CFileHelper::getExtension($testFileName);

		$this->assertTrue($activeRecord->saveFile($testFileName), 'Unable to save file!');

		$refreshedActiveRecord = $activeRecordFinder->findByPk($activeRecord->getPrimaryKey());

		foreach ($fileTransforms as $fileTransformName => $fileTransform) {
			$returnedFileFullName = $activeRecord->getFileFullName($fileTransformName);
			$fileStorageBucket = $activeRecord->getFileStorageBucket();

			$this->assertTrue($fileStorageBucket->fileExists($returnedFileFullName), "File for transformation name '{$fileTransformName}' does not exist!");
			$this->assertEquals(CFileHelper::getExtension($returnedFileFullName), $testFileExtension, 'Saved file has wrong extension!');

			$this->assertEquals($refreshedActiveRecord->getFileFullName($fileTransformName), $returnedFileFullName, 'Wrong full file name from the refreshed record!');
		}
	}

	/**
	 * @depends testTransformCallbackSetUp
	 * @depends testDefaultFileUrlSetUp
	 * @depends testTransformSetUp
	 */
	public function testUseDefaultFileUrl() {
		$activeRecordModel = $this->getActiveRecordFinder();
		$activeRecord = $activeRecordModel->find(null);

		// Single string:
		$emptyDefaultFileWebSrc = '';
		$activeRecord->setDefaultFileUrl($emptyDefaultFileWebSrc);
		$returnedFileWebSrc = $activeRecord->getFileUrl();
		$this->assertFalse(empty($returnedFileWebSrc), 'Unable to get file web src with empty default one!');

		$testDefaultFileWebSrc = 'http://test/default/file/web/src';
		$activeRecord->setDefaultFileUrl($testDefaultFileWebSrc);
		$returnedFileWebSrc = $activeRecord->getFileUrl();
		$this->assertEquals($returnedFileWebSrc, $testDefaultFileWebSrc, 'Default file web src does not used!');

		// Array:
		$transformNamePrefix = 'test_transform_';
		$defaultWebSrcPrefix = 'http://default/';
		$transformsCount = 3;
		$testDefaultFileWebSrcArray = array();
		for ($i=1; $i<=$transformsCount; $i++) {
			$transformName = $transformNamePrefix.$i;
			$defaultWebSrc = $defaultWebSrcPrefix.$i.rand();
			$testDefaultFileWebSrcArray[$transformName] = $defaultWebSrc;
		}
		$activeRecord->setDefaultFileUrl($testDefaultFileWebSrcArray);

		for ($i=1; $i<=$transformsCount; $i++) {
			$transformName = $transformNamePrefix.$i;
			$returnedMainFileWebSrc = $activeRecord->getFileUrl($transformName);
			$this->assertEquals($returnedMainFileWebSrc, $testDefaultFileWebSrcArray[$transformName], 'Unable to apply default file web src per each transfromation!');
		}
	}
}
