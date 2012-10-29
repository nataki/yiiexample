<?php

/**
 * Test case for the extension "ext.qs.lib.db.ar.QsActiveRecordBehaviorFile".
 * @see QsActiveRecordBehaviorFile
 */
class QsActiveRecordBehaviorFileTest extends CTestCase {
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
				'tableName'=>$testTableName,
				'behaviors'=>array(
					'fileBehavior' => array(
						'class'=>'ext.qs.lib.db.ar.QsActiveRecordBehaviorFile',
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
			'class'=>'QsFileStorageFileSystem',
			'basePath'=>self::getTestFileStorageBasePath(),
			'baseUrl'=>'http://www.mydomain.com/files',
			'filePermission'=>0777
		);
		return $fileStorageConfig;
	}

	/**
	 * Returns the test active record finder.
	 * @return CActiveRecord active record finder instance.
	 */
	protected function getActiveRecordFinder() {
		return CActiveRecord::model( self::getTestActiveRecordClassName() );
	}

	/**
	 * Creates new test active record instance.
	 * @return CActiveRecord active record instance.
	 */
	protected function newActiveRecord() {
		$className = self::getTestActiveRecordClassName();
		$activeRecord = new $className();
		return $activeRecord;
	}

	// Tests:

	public function testCreate() {
		$behavior = new QsActiveRecordBehaviorFile();
		$this->assertTrue( is_object($behavior) );
	}

	/**
	 * @depends testCreate
	 */
	public function testSetGet() {
		$behavior = new QsActiveRecordBehaviorFile();

		$testFilePropertyName = 'test_file_property_name';
		$this->assertTrue( $behavior->setFilePropertyName($testFilePropertyName), 'Unable to set file property name!' );
		$this->assertEquals( $behavior->getFilePropertyName(), $testFilePropertyName, 'Unable to set file property name correctly!' );

		$testFileStorageComponentName = 'testFileStorageComponentName';
		$this->assertTrue( $behavior->setFileStorageComponentName($testFileStorageComponentName), 'Unable to set file storage component name!' );
		$this->assertEquals( $behavior->getFileStorageComponentName(), $testFileStorageComponentName, 'Unable to set file storage component name correctly!' );

		$testFileStorageBucketName = 'testFileStorageBucketName';
		$this->assertTrue( $behavior->setFileStorageBucketName($testFileStorageBucketName), 'Unable to set file storage bucket name!' );
		$this->assertEquals( $behavior->getFileStorageBucketName(), $testFileStorageBucketName, 'Unable to set file storage bucket name correctly!' );

		$testFileExtensionAttributeName = 'test_file_extension_attribute_name';
		$this->assertTrue( $behavior->setFileExtensionAttributeName($testFileExtensionAttributeName), 'Unable to set file extension attribute name!' );
		$this->assertEquals( $behavior->getFileExtensionAttributeName(), $testFileExtensionAttributeName, 'Unable to set file extension attribute name correctly!' );

		$testFileVersionAttributeName = 'test_file_version_attribute_name';
		$this->assertTrue( $behavior->setFileVersionAttributeName($testFileVersionAttributeName), 'Unable to set file version attribute name!' );
		$this->assertEquals( $behavior->getFileVersionAttributeName(), $testFileVersionAttributeName, 'Unable to set file version attribute name correctly!' );

		$testSubDirTemplate = 'test/subdir/template';
		$this->assertTrue( $behavior->setSubDirTemplate($testSubDirTemplate), 'Unable to set sub dir template!' );
		$this->assertEquals( $behavior->getSubDirTemplate(), $testSubDirTemplate, 'Unable to set sub dir template correctly!' );

		$testFileTabularInputIndex = rand(1, 100);
		$this->assertTrue( $behavior->setFileTabularInputIndex($testFileTabularInputIndex), 'Unable to set file tabular input index!' );
		$this->assertEquals( $behavior->getFileTabularInputIndex(), $testFileTabularInputIndex, 'Unable to set file tabular input index correctly!' );

		$testDefaultFileUrl = 'http://test/default/file';
		$this->assertTrue( $behavior->setDefaultFileUrl($testDefaultFileUrl), 'Unable to set default file URL!' );
		$this->assertEquals( $testDefaultFileUrl, $behavior->getDefaultFileUrl(), 'Unable to set default file URL correctly!' );
	}

	/**
	 * @depends testSetGet
	 */
	public function testGetDefaultFileStorageBucketName() {
		$activeRecord = $this->newActiveRecord();

		$activeRecord->setFileStorageBucketName('');
		$defaultFileStorageBucketName = $activeRecord->getFileStorageBucketName();

		$this->assertFalse( empty($defaultFileStorageBucketName), 'Unable to get default file storage bucket name!' );

		$expectedFileStorageBucketName = get_class($activeRecord).ucfirst($activeRecord->getFilePropertyName());
		$this->assertEquals($expectedFileStorageBucketName, $defaultFileStorageBucketName, 'Wrong default vallue of file storage bucket name!');
	}

	/**
	 * @depends testGetDefaultFileStorageBucketName
	 */
	public function testGetFileStorageBucket() {
		$testBucketName = 'testBucketName';
		Yii::app()->fileStorage->addBucket($testBucketName);

		$activeRecord = $this->newActiveRecord();
		$activeRecord->setFileStorageBucketName($testBucketName);

		$fileStorageBucket = $activeRecord->getFileStorageBucket();

		$this->assertTrue(is_object($fileStorageBucket), 'Unable to get file storage bucket!');
		$this->assertEquals($testBucketName, $fileStorageBucket->getName(), 'Returned file storage bucket has incorrect name!');
	}

	/**
	 * @depends testGetFileStorageBucket
	 */
	public function testGetFileStorageBucketIfNotExists() {
		Yii::app()->fileStorage->setBuckets( array() );

		$testBucketName = 'testBucketNameWhichNotPresentInStorage';

		$activeRecord = $this->newActiveRecord();
		$activeRecord->setFileStorageBucketName($testBucketName);

		$fileStorageBucket = $activeRecord->getFileStorageBucket();

		$this->assertTrue(is_object($fileStorageBucket), 'Unable to get file storage bucket!');
		$this->assertEquals($testBucketName, $fileStorageBucket->getName(), 'Returned file storage bucket has incorrect name!');
	}

	/**
	 * @depends testSetGet
	 */
	public function testGetActualSubDirPath() {
		$activeRecordFinder = $this->getActiveRecordFinder();

		$activeRecord = $activeRecordFinder->find(null);

		$testSubDirTemplate = 'test/{pk}/subdir/template';
		$activeRecord->setSubDirTemplate($testSubDirTemplate);
		$actualSubDir = $activeRecord->getActualSubDir();
		$expectedActualSubDir = str_replace('{pk}', $activeRecord->getPrimaryKey(), $testSubDirTemplate);
		$this->assertEquals($actualSubDir, $expectedActualSubDir, 'Actual sub dir can not parse primary key!');


		$activeRecord->setPrimaryKey(54321);
		$testSubDirTemplate = 'test/{^pk}/subdir/template';
		$activeRecord->setSubDirTemplate($testSubDirTemplate);
		$actualSubDir = $activeRecord->getActualSubDir();
		$expectedActualSubDir = str_replace('{^pk}', substr($activeRecord->getPrimaryKey(),0,1), $testSubDirTemplate);
		$this->assertEquals($actualSubDir, $expectedActualSubDir, 'Actual sub dir can not parse primary key first symbol!');

		$activeRecord->setPrimaryKey(54321);
		$testSubDirTemplate = 'test/{^^pk}/subdir/template';
		$activeRecord->setSubDirTemplate($testSubDirTemplate);
		$actualSubDir = $activeRecord->getActualSubDir();
		$expectedActualSubDir = str_replace('{^^pk}', substr($activeRecord->getPrimaryKey(),1,1), $testSubDirTemplate);
		$this->assertEquals($actualSubDir, $expectedActualSubDir, 'Actual sub dir can not parse primary key second symbol!');

		$testPropertyName = 'name';
		$testSubDirTemplate = 'test/{'.$testPropertyName.'}/subdir/template';
		$activeRecord->setSubDirTemplate($testSubDirTemplate);
		$actualSubDir = $activeRecord->getActualSubDir();
		$expectedActualSubDir = str_replace('{'.$testPropertyName.'}', $activeRecord->$testPropertyName, $testSubDirTemplate);
		$this->assertEquals($actualSubDir, $expectedActualSubDir, 'Actual sub dir can not parse property!');
	}

	/**
	 * @depends testGetActualSubDirPath
	 */
	public function testSaveFile() {
		$activeRecordFinder = $this->getActiveRecordFinder();

		$activeRecord = $activeRecordFinder->find(null);

		$testFileSourcePath = $this->getTestSourceBasePath();

		$testFileExtention = 'ext';
		$testFileName = $testFileSourcePath.'/test_file_name.'.$testFileExtention;
		$testFileContent = 'Test File Content';
		if (file_exists($testFileName)) unlink($testFileName);
		file_put_contents($testFileName, $testFileContent);

		$this->assertTrue( $activeRecord->saveFile($testFileName), 'Unable to save file!' );

		$returnedFileFullName = $activeRecord->getFileFullName();
		$fileStorageBucket = $activeRecord->getFileStorageBucket();

		$this->assertTrue( $fileStorageBucket->fileExists($returnedFileFullName), 'Unable to save file in the file storage bucket!' );

		$this->assertEquals( $fileStorageBucket->getFileContent($returnedFileFullName), $testFileContent, 'Saved file has wrong content!' );
		$this->assertEquals( CFileHelper::getExtension($returnedFileFullName), $testFileExtention, 'Saved file has wrong extension!' );

		$refreshedActiveRecord = $activeRecordFinder->findByPk($activeRecord->getPrimaryKey());
		$this->assertEquals( $refreshedActiveRecord->getFileFullName(), $returnedFileFullName, 'Wrong file full name returned from the refreshed record!' );
	}

	/**
	 * @depends testSaveFile
	 */
	public function testFilePropertySetUp() {
		$activeRecordModel = $this->getActiveRecordFinder();

		$testFileSourcePath = $this->getTestSourceBasePath();
		$testFileName = $testFileSourcePath.'/test_file_name.test';
		$testFileContent = 'Test File Content';
		if (file_exists($testFileName)) unlink($testFileName);
		file_put_contents($testFileName, $testFileContent);

		$activeRecordModel->file = $testFileName;

		$this->assertTrue( is_object($activeRecordModel->file), 'Unable to set file property!' );
		$this->assertEquals( $activeRecordModel->file->getTempName(), $testFileName, 'Wrong temp file name, while setting file property!' );
	}

	/**
	 * @depends testSaveFile
	 */
	public function testModelSave() {
		$activeRecordFinder = $this->getActiveRecordFinder();
		$activeRecord = $activeRecordFinder->find();

		$testFileSourcePath = $this->getTestSourceBasePath();
		$testFileName = $testFileSourcePath.'/test_file_name.test';
		$testFileContent = 'Test File Content';
		if (file_exists($testFileName)) {
			unlink($testFileName);
		}
		file_put_contents($testFileName, $testFileContent);

		$activeRecord->file = $testFileName;

		$this->assertTrue( $activeRecord->save(), 'Unable to save record with file!' );

		$fileStorageBucket = $activeRecord->getFileStorageBucket();
		$returnedFileFullName = $activeRecord->getFileFullName();

		$this->assertTrue( $fileStorageBucket->fileExists($returnedFileFullName), 'Unable to save file in the file storage bucket!' );
		$this->assertEquals( $fileStorageBucket->getFileContent($returnedFileFullName), $testFileContent, 'Saved file has wrong content!' );
	}

	/**
	 * @depends testSaveFile
	 */
	public function testSaveFileFromWeb() {
		$activeRecordClassName = self::getTestActiveRecordClassName();
		$testFileSourcePath = $this->getTestSourceBasePath();

		$activeRecord = $this->newActiveRecord();
		$activeRecord->name = 'test_name';

		$testFileName = $testFileSourcePath."/test_file_name.txt";
		$testFileContent = "Test File Content";
		if (file_exists($testFileName)) {
			unlink($testFileName);
		}
		file_put_contents($testFileName, $testFileContent);

		$_FILES[$activeRecordClassName]['name'][$activeRecord->getFilePropertyName()] = basename($testFileName);
		$_FILES[$activeRecordClassName]['type'][$activeRecord->getFilePropertyName()] = CFileHelper::getExtension($testFileName);
		$_FILES[$activeRecordClassName]['tmp_name'][$activeRecord->getFilePropertyName()] = $testFileName;
		$_FILES[$activeRecordClassName]['error'][$activeRecord->getFilePropertyName()] = UPLOAD_ERR_OK;
		$_FILES[$activeRecordClassName]['size'][$activeRecord->getFilePropertyName()] = filesize($testFileName);

		$this->assertTrue( $activeRecord->save(), 'Unable to save record with file fetched from Web!' );

		$fileStorageBucket = $activeRecord->getFileStorageBucket();
		$returnedFileFullName = $activeRecord->getFileFullName();

		$this->assertTrue( $fileStorageBucket->fileExists($returnedFileFullName), 'Unable to save file from Web in the file storage bucket!' );
		$this->assertEquals( $fileStorageBucket->getFileContent($returnedFileFullName), $testFileContent, 'Saved from Web file has wrong content!' );
	}

	/**
	 * @depends testSaveFileFromWeb
	 */
	public function testSaveFromWebTabular() {
		$activeRecordClassName = self::getTestActiveRecordClassName();
		$testFileSourcePath = $this->getTestSourceBasePath();

		$activeRecords = array();

		$testActiveRecordCount = 10;

		for ($i=1; $i<=$testActiveRecordCount; $i++) {
			$activeRecord = $this->newActiveRecord();
			$activeRecord->name = 'test_name_'.$i;
			$activeRecords[] = $activeRecord;
		}

		// Mock up $_FILES:
		$testFileContents = array();
		foreach ($activeRecords as $index => $activeRecord) {
			$testFileName = $testFileSourcePath."/test_file_name_{$index}.test";
			$testFileContent = "Test File Content {$index}";
			$testFileContents[$index] = $testFileContent;
			if (file_exists($testFileName)) {
				unlink($testFileName);
			}
			file_put_contents($testFileName, $testFileContent);

			$_FILES[$activeRecordClassName]['name'][$index][$activeRecord->getFilePropertyName()] = basename($testFileName);
			$_FILES[$activeRecordClassName]['type'][$index][$activeRecord->getFilePropertyName()] = CFileHelper::getExtension($testFileName);
			$_FILES[$activeRecordClassName]['tmp_name'][$index][$activeRecord->getFilePropertyName()] = $testFileName;
			$_FILES[$activeRecordClassName]['error'][$index][$activeRecord->getFilePropertyName()] = UPLOAD_ERR_OK;
			$_FILES[$activeRecordClassName]['size'][$index][$activeRecord->getFilePropertyName()] = filesize($testFileName);
		}

		foreach ($activeRecords as $index => $activeRecord) {
			$activeRecord->setFileTabularInputIndex($index);

			$this->assertTrue( $activeRecord->save(), 'Unable to save record with tabular input file!' );

			$fileStorageBucket = $activeRecord->getFileStorageBucket();
			$returnedFileFullName = $activeRecord->getFileFullName();

			$this->assertTrue( $fileStorageBucket->fileExists($returnedFileFullName), 'Unable to save file with tabular input!' );
			$this->assertEquals( $fileStorageBucket->getFileContent($returnedFileFullName), $testFileContents[$index], 'Saved with tabular input file has wrong content!' );
		}
	}

	/**
	 * @depends testSaveFile
	 */
	public function testUseDefaultFileUrl() {
		$activeRecordModel = $this->getActiveRecordFinder();
		$activeRecord = $activeRecordModel->find(null);

		// Single string:
		$emptyDefaultFileWebSrc = '';
		$activeRecord->setDefaultFileUrl($emptyDefaultFileWebSrc);
		$returnedFileWebSrc = $activeRecord->getFileUrl();
		$this->assertTrue( !empty($returnedFileWebSrc), 'Unable to get file web src with empty default one!' );

		$testDefaultFileWebSrc = 'http://test/default/file/web/src';
		$activeRecord->setDefaultFileUrl($testDefaultFileWebSrc);
		$returnedFileWebSrc = $activeRecord->getFileUrl();
		$this->assertEquals( $returnedFileWebSrc, $testDefaultFileWebSrc, 'Default file web src does not used!' );
	}
}
