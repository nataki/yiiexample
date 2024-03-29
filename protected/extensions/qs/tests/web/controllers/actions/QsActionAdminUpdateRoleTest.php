<?php

/**
 * Test case for the extension "ext.qs.lib.web.controllers.actions.QsActionAdminUpdateRole".
 * @see QsActionAdminUpdateRole
 */
class QsActionAdminUpdateRoleTest extends CTestCase {
	const TEST_RECORDS_COUNT = 5;
	/**
	 * @var CHttpRequest request component backup.
	 */
	protected static $_requestBackup = null;

	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.web.controllers.actions.*');
		Yii::import('ext.qs.lib.web.controllers.*');

		/// Components:
		self::$_requestBackup = Yii::app()->getRequest();
		$mockRequestConfig = array(
			'class' => 'QsTestHttpRequest'
		);
		$mockRequest = Yii::createComponent($mockRequestConfig);
		Yii::app()->setComponent('request', $mockRequest);

		// Database:
		$dbSetUp = new QsTestDbMigration();
		$activeRecordGenerator = new QsTestActiveRecordGenerator();

		// Slave:
		$testSlaveTableName = self::getTestSlaveTableName();
		$columns = array(
			'id' => 'pk',
			'master_id' => 'integer',
			'slave_name' => 'string',
		);
		$dbSetUp->createTable($testSlaveTableName, $columns);

		$activeRecordGenerator->generate(
			array(
				'tableName' => $testSlaveTableName,
				'rules' => array(
					array('slave_name', 'required'),
				),
			)
		);

		// Master:
		$testMasterTableName = self::getTestMasterTableName();
		$columns = array(
			'id' => 'pk',
			'master_name' => 'string',
		);
		$dbSetUp->createTable($testMasterTableName, $columns);

		$activeRecordGenerator->generate(
			array(
				'tableName' => $testMasterTableName,
				'rules' => array(
					array('master_name', 'required'),
				),
				'behaviors' => array(
					'roleBehavior' => array(
						'class' => 'ext.qs.lib.db.ar.QsActiveRecordBehaviorRole',
						'relationName' => 'slave',
						'relationConfig' => array(
							$testSlaveTableName, 'master_id'
						),
					),
				),
			)
		);
	}

	public static function tearDownAfterClass() {
		Yii::app()->setComponent('request', self::$_requestBackup);

		$dbSetUp = new QsTestDbMigration();
		$dbSetUp->dropTable(self::getTestMasterTableName());
		$dbSetUp->dropTable(self::getTestSlaveTableName());
	}

	public function setUp() {
		$dbSetUp = new QsTestDbMigration();
		$testMasterTableName = self::getTestMasterTableName();
		$testSlaveTableName = self::getTestSlaveTableName();

		$dbSetUp->truncateTable($testMasterTableName);
		$dbSetUp->truncateTable($testSlaveTableName);

		for ($i=1; $i<=self::TEST_RECORDS_COUNT; $i++) {
			$columns = array(
				'master_name' => 'test_master_name_'.$i,
			);
			$dbSetUp->insert($testMasterTableName, $columns);
			$columns = array(
				'master_id' => $i,
				'slave_name' => 'test_slave_name_'.$i,
			);
			$dbSetUp->insert($testSlaveTableName, $columns);
		}
	}

	/**
	 * Returns the name of the master test table.
	 * @return string test table name.
	 */
	public static function getTestMasterTableName() {
		return 'test_master_'.__CLASS__.'_'.getmypid();
	}

	/**
	 * Returns the name of the master test active record class.
	 * @return string test active record class name.
	 */
	public static function getTestMasterActiveRecordClassName() {
		return self::getTestMasterTableName();
	}

	/**
	 * Returns the name of the slave test table.
	 * @return string test table name.
	 */
	public static function getTestSlaveTableName() {
		return 'test_slave_'.__CLASS__.'_'.getmypid();
	}

	/**
	 * Returns the name of the slave test active record class.
	 * @return string test active record class name.
	 */
	public static function getTestSlaveActiveRecordClassName() {
		return self::getTestSlaveTableName();
	}

	/**
	 * @return QsTestController test controller instance.
	 */
	public function createMockController() {
		$mockController = new QsTestController();

		$dataModelBehavior = new QsControllerBehaviorAdminDataModel();
		$dataModelBehavior->setModelClassName(self::getTestMasterActiveRecordClassName());
		$mockController->attachBehavior('dataModelBehavior', $dataModelBehavior);

		return $mockController;
	}

	// Tests:

	public function testCreate() {
		$controller = new CController('test');
		$action = new QsActionAdminUpdateRole($controller, 'test');
		$this->assertTrue(is_object($action), 'Unable to create "QsActionAdminUpdateRole" instance!');
	}

	/**
	 * @depends testCreate
	 */
	public function testViewForm() {
		$mockController = $this->createMockController();
		$action = new QsActionAdminUpdateRole($mockController, 'test');

		$testId = rand(1, self::TEST_RECORDS_COUNT);
		$_GET['id'] = $testId;

		$viewRendered = false;
		try {
			$mockController->runAction($action);
		} catch (QsTestExceptionRender $exception) {
			$viewRendered = true;
		}

		$this->assertTrue($viewRendered, 'View is not rendered!');
	}

	/**
	 * @depends testViewForm
	 */
	public function testViewFormMissingModel() {
		$mockController = $this->createMockController();
		$action = new QsActionAdminUpdateRole($mockController, 'test');

		$testId = rand(self::TEST_RECORDS_COUNT+1, self::TEST_RECORDS_COUNT*2);
		$_GET['id'] = $testId;

		$errorMissingPageRisen = false;
		try {
			$mockController->runAction($action);
		} catch (CHttpException $exception) {
			$errorMissingPageRisen = true;
		}

		$this->assertTrue($errorMissingPageRisen, 'No 404 error, while updating unexisting model!');
	}

	/**
	 * @depends testViewForm
	 */
	public function testSubmitForm() {
		$mockController = $this->createMockController();
		$action = new QsActionAdminUpdateRole($mockController, 'test');

		$testId = rand(1, self::TEST_RECORDS_COUNT);
		$_GET['id'] = $testId;

		$testMasterRecordName = 'test_master_record_name_'.rand(1, 100);
		$testSlaveRecordName = 'test_slave_record_name_'.rand(1, 100);

		$modelClassName = self::getTestMasterActiveRecordClassName();
		$model = CActiveRecord::model($modelClassName);
		$subModelClassName = $model->getRelationConfigParam('class');

		$_POST[$modelClassName] = array(
			'master_name' => $testMasterRecordName,
		);
		$_POST[$subModelClassName] = array(
			'slave_name' => $testSlaveRecordName,
		);

		$pageRedirected = false;
		try {
			$mockController->runAction($action);
		} catch (QsTestExceptionRedirect $exception) {
			$pageRedirected = true;
		}
		$this->assertTrue($pageRedirected, 'Page has not been redirected!');

		$updatedModel = CActiveRecord::model($modelClassName)->findByPk($testId);
		$this->assertEquals($updatedModel->master_name, $testMasterRecordName, 'Can not update master record!');
		$this->assertEquals($updatedModel->slave->slave_name, $testSlaveRecordName, 'Can not update slave record!');
	}

	/**
	 * @depends testViewForm
	 */
	public function testSubmitFormWithError() {
		$mockController = $this->createMockController();
		$action = new QsActionAdminUpdateRole($mockController, 'test');

		$testId = rand(1, self::TEST_RECORDS_COUNT);
		$_GET['id'] = $testId;

		$_POST[self::getTestMasterActiveRecordClassName()] = array(
			'master_name' => null,
		);

		$pageRendered = false;
		try {
			$mockController->runAction($action);
		} catch (QsTestExceptionRender $exception) {
			$pageRendered = true;
		}
		$this->assertTrue($pageRendered, 'Page has not been rendered after request with empty post!');
	}
}
