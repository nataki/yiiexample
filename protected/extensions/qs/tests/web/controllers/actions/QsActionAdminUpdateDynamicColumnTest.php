<?php
 
/**
 * Test case for the extension "ext.qs.lib.web.controllers.actions.QsActionAdminUpdateDynamicColumn".
 * @see QsActionAdminUpdateDynamicColumn
 */
class QsActionAdminUpdateDynamicColumnTest extends CTestCase {
	const TEST_COLUMN_RECORDS_COUNT = 3;
	const TEST_MAIN_RECORDS_COUNT = 5;
	protected static $_requestBackup = null;

	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.web.controllers.actions.*');
		Yii::import('ext.qs.lib.web.controllers.*');

		// Components:
		self::$_requestBackup = Yii::app()->getRequest();
		$mockRequestConfig = array(
			'class' => 'QsTestHttpRequest'
		);
		$mockRequest = Yii::createComponent($mockRequestConfig);
		Yii::app()->setComponent('request', $mockRequest);

		// Database:
		$dbSetUp = new QsTestDbMigration();
		$activeRecordGenerator = new QsTestActiveRecordGenerator();

		// Column:
		$testColumnTableName = self::getTestColumnTableName();
		$columns = array(
			'id' => 'pk',
			'name' => 'string',
			'default_value' => 'string',
		);
		$dbSetUp->createTable($testColumnTableName, $columns);

		for ($i=1; $i<=self::TEST_COLUMN_RECORDS_COUNT; $i++) {
			$data = array(
				'name' => 'column_'.$i,
				'default_value' => 'default_value_'.$i
			);
			$dbSetUp->insert($testColumnTableName, $data);
		}

		$activeRecordGenerator->generate(
			array(
				'tableName' => $testColumnTableName,
				'rules' => array(
					array('name', 'required'),
					array('default_value', 'safe'),
				),
			)
		);

		// Column Values:
		$testColumnValueTableName = self::getTestColumnValueTableName();
		$columns = array(
			'id' => 'pk',
			'main_id' => 'integer',
			'column_id' => 'integer',
			'value' => 'string',
		);
		$dbSetUp->createTable($testColumnValueTableName, $columns);

		$activeRecordGenerator->generate(
			array(
				'tableName' => $testColumnValueTableName,
				'rules' => array(
					array('main_id,column_id,value', 'safe'),
					array('main_id,column_id', 'numerical', 'integerOnly'=>true)
				),
			)
		);

		// Main:
		$testMainTableName = self::getTestMainTableName();
		$columns = array(
			'id' => 'pk',
			'name' => 'string',
		);
		$dbSetUp->createTable($testMainTableName, $columns);

		$activeRecordGenerator->generate(
			array(
				'tableName' => $testMainTableName,
				'rules' => array(
					array('name', 'required'),
				),
				'behaviors' => array(
					'dynamicColumnBehavior' => array(
						'class' => 'ext.qs.lib.db.ar.QsActiveRecordBehaviorDynamicColumn',
						'columnModelClassName' => $testColumnTableName,
						'relationConfig' => array(
							$testColumnValueTableName, 'main_id'
						),
					)
				),
			)
		);
	}

	public static function tearDownAfterClass() {
		Yii::app()->setComponent('request', self::$_requestBackup);

		$dbSetUp = new QsTestDbMigration();
		$dbSetUp->dropTable(self::getTestColumnTableName());
		$dbSetUp->dropTable(self::getTestMainTableName());
		$dbSetUp->dropTable(self::getTestColumnValueTableName());
	}

	public function setUp() {
		$dbSetUp = new QsTestDbMigration();
		$testMainTableName = self::getTestMainTableName();
		$testColumnValueTableName = self::getTestColumnValueTableName();

		$dbSetUp->truncateTable($testMainTableName);
		$dbSetUp->truncateTable($testColumnValueTableName);

		for ($mainId=1; $mainId<=self::TEST_MAIN_RECORDS_COUNT; $mainId++) {
			$columns = array(
				'name' => 'test_main_name_'.$mainId,
			);
			$dbSetUp->insert($testMainTableName, $columns);
			for ($columnId=1; $columnId<=self::TEST_COLUMN_RECORDS_COUNT; $columnId++) {
				$columns = array(
					'main_id' => $mainId,
					'column_id' => $columnId,
					'value' => 'test_column_value_'.$mainId.'/'.$columnId,
				);
				$dbSetUp->insert($testColumnValueTableName, $columns);
			}
		}
	}

	/**
	 * Returns the name of the column test table.
	 * @return string test table name.
	 */
	public static function getTestColumnTableName() {
		return 'test_column_'.__CLASS__.'_'.getmypid();
	}

	/**
	 * Returns the name of the column test active record class.
	 * @return string test active record class name.
	 */
	public static function getTestColumnActiveRecordClassName() {
		return self::getTestColumnTableName();
	}

	/**
	 * Returns the name of the main test table.
	 * @return string test table name.
	 */
	public static function getTestMainTableName() {
		return 'test_main_'.__CLASS__.'_'.getmypid();
	}

	/**
	 * Returns the name of the main test active record class.
	 * @return string test active record class name.
	 */
	public static function getTestMainActiveRecordClassName() {
		return self::getTestMainTableName();
	}

	/**
	 * Returns the name of the column value test table.
	 * @return string test table name.
	 */
	public static function getTestColumnValueTableName() {
		return 'test_variation_'.__CLASS__.'_'.getmypid();
	}

	/**
	 * Returns the name of the column value test active record class.
	 * @return string test active record class name.
	 */
	public static function getTestColumnValueActiveRecordClassName() {
		return self::getTestColumnValueTableName();
	}

	/**
	 * Returns the model finder for the test active record.
	 * @return CActiveRecord model finder.
	 */
	public function getActiveRecordFinder() {
		$activeRecord = CActiveRecord::model(self::getTestMainActiveRecordClassName());
		return $activeRecord;
	}

	/**
	 * @return QsTestController test controller instance.
	 */
	public function createMockController() {
		$mockController = new QsTestController();

		$dataModelBehavior = new QsControllerBehaviorAdminDataModel();
		$dataModelBehavior->setModelClassName(self::getTestMainActiveRecordClassName());
		$mockController->attachBehavior('dataModelBehavior', $dataModelBehavior);

		return $mockController;
	}

	// Tests:

	public function testCreate() {
		$controller = new CController('test');
		$action = new QsActionAdminUpdateDynamicColumn($controller, 'test');
		$this->assertTrue(is_object($action), 'Unable to create "QsActionAdminUpdateDynamicColumn" instance!');
	}

	/**
	 * @depends testCreate
	 */
	public function testViewForm() {
		$mockController = $this->createMockController();
		$action = new QsActionAdminUpdateDynamicColumn($mockController, 'test');

		$testId = rand(1, self::TEST_MAIN_RECORDS_COUNT);
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
		$action = new QsActionAdminUpdateDynamicColumn($mockController, 'test');

		$testId = rand(self::TEST_MAIN_RECORDS_COUNT+1, self::TEST_MAIN_RECORDS_COUNT*2);
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
		$action = new QsActionAdminUpdateDynamicColumn($mockController, 'test');

		$testId = rand(1, self::TEST_MAIN_RECORDS_COUNT);
		$_GET['id'] = $testId;

		$modelClassName = self::getTestMainActiveRecordClassName();
		$model = CActiveRecord::model($modelClassName);
		$columnValueClassName = $model->getRelationConfigParam('class');

		$testMainRecordName = 'test_main_record_name_'.rand(1,100);
		$columnValuePostData = array();
		$columnModels = CActiveRecord::model(self::getTestColumnActiveRecordClassName())->findAll();
		foreach ($columnModels as $columnModel) {
			$columnValuePostData[$columnModel->name] = array(
				'value' => 'test_column_value_'.rand(1,100)
			);
		}

		$_POST[$modelClassName] = array(
			'name' => $testMainRecordName,
		);
		$_POST[$columnValueClassName] = $columnValuePostData;

		$pageRedirected = false;
		try {
			$mockController->runAction($action);
		} catch (QsTestExceptionRedirect $exception) {
			$pageRedirected = true;
		}
		$this->assertTrue( $pageRedirected, 'Page has not been redirected!' );

		$updatedModel = CActiveRecord::model($modelClassName)->findByPk($testId);
		$this->assertEquals($updatedModel->name, $testMainRecordName, 'Can not update main record!');
		$this->assertEquals(count($updatedModel->columnValues), count($columnModels), 'Count of updated column value models missmatch the count of columns!');

		foreach ($updatedModel->getColumnValueModels() as $columnValueKey => $columnValueModel) {
			$this->assertEquals($columnValueModel->value, $columnValuePostData[$columnValueKey]['value'], 'Column value record has wrong data!');
		}
	}

	/**
	 * @depends testViewForm
	 */
	public function testSubmitFormWithError() {
		$mockController = $this->createMockController();
		$action = new QsActionAdminUpdateDynamicColumn($mockController, 'test');

		$testId = rand(1, self::TEST_MAIN_RECORDS_COUNT);
		$_GET['id'] = $testId;

		$_POST[self::getTestMainActiveRecordClassName()] = array(
			'name' => null,
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
