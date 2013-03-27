<?php

require_once( realpath(dirname(__FILE__).'/../../lib/requirements/QsRequirementsChecker.php') );

/**
 * Test case for the extension "ext.qs.lib.requirements.QsRequirementsChecker".
 * @see QsRequirementsChecker
 */
class QsRequirementsCheckerTest extends CTestCase {
	/**
	 * Creates requirements checker with the empty default requirements list.
	 * @return QsRequirementsChecker requirements checker instance.
	 */
	protected function createRequirementsCheckerWithEmptyDefaults() {
		$requirementsChecker = $this->getMock('QsRequirementsChecker', array('getDefaultRequirements'));
		$requirementsChecker->expects($this->any())->method('getDefaultRequirements')->will($this->returnValue(array()));
		return $requirementsChecker;
	}

	// Tests:

	public function testMergeArray() {
		$requirementsChecker = new QsRequirementsChecker();

		$a = array(
			'key_1' => array(
				'key_1_1' => 'value_1_1',
				'key_1_2' => 'value_1_2',
			),
			'key_2' => array(
				'key_2_1' => 'value_2_1',
				'key_2_2' => 'value_2_2',
			),
		);
		$b = array(
			'key_2' => array(
				'key_2_2' => 'new_value_2_2',
			),
			'key_3' => array(
				'key_3_1' => 'value_3_1',
				'key_3_2' => 'value_3_2',
			),
		);
		$mergedArray = $requirementsChecker->mergeArray($a, $b);

		$expectedMergedArray = $a;
		$expectedMergedArray['key_2']['key_2_2'] = $b['key_2']['key_2_2'];
		$expectedMergedArray['key_3']= $b['key_3'];

		$this->assertEquals($expectedMergedArray, $mergedArray);
	}

	public function testCheck() {
		$requirementsChecker = $this->createRequirementsCheckerWithEmptyDefaults();

		$requirements = array(
			'requirementPass' => array(
				'name' => 'Requirement 1',
				'mandatory' => true,
				'condition' => true,
				'by' => 'Requirement 1',
				'memo' => 'Requirement 1',
			),
			'requirementError' => array(
				'name' => 'Requirement 2',
				'mandatory' => true,
				'condition' => false,
				'by' => 'Requirement 2',
				'memo' => 'Requirement 2',
			),
			'requirementWarning' => array(
				'name' => 'Requirement 3',
				'mandatory' => false,
				'condition' => false,
				'by' => 'Requirement 3',
				'memo' => 'Requirement 3',
			),
		);

		$checkResult = $requirementsChecker->check($requirements);
		$summary = $checkResult['summary'];

		$this->assertEquals(count($requirements), $summary['total'], 'Wrong summary total!');
		$this->assertEquals(1, $summary['errors'], 'Wrong summary errors!');
		$this->assertEquals(1, $summary['warnings'], 'Wrong summary warnings!');

		$checkedRequirements = $checkResult['requirements'];

		$this->assertEquals(false, $checkedRequirements['requirementPass']['error'], 'Passed requirement has an error!');
		$this->assertEquals(false, $checkedRequirements['requirementPass']['warning'], 'Passed requirement has a warning!');

		$this->assertEquals(true, $checkedRequirements['requirementError']['error'], 'Error requirement has no error!');

		$this->assertEquals(false, $checkedRequirements['requirementWarning']['error'], 'Error requirement has an error!');
		$this->assertEquals(true, $checkedRequirements['requirementWarning']['warning'], 'Error requirement has no warning!');
	}

	public function testCheckEval() {
		$requirementsChecker = $this->createRequirementsCheckerWithEmptyDefaults();

		$requirements = array(
			'requirementPass' => array(
				'name' => 'Requirement 1',
				'mandatory' => true,
				'condition' => 'eval:2>1',
				'by' => 'Requirement 1',
				'memo' => 'Requirement 1',
			),
			'requirementError' => array(
				'name' => 'Requirement 2',
				'mandatory' => true,
				'condition' => 'eval:2<1',
				'by' => 'Requirement 2',
				'memo' => 'Requirement 2',
			),
		);

		$checkResult = $requirementsChecker->check($requirements);
		$checkedRequirements = $checkResult['requirements'];

		$this->assertEquals(false, $checkedRequirements['requirementPass']['error'], 'Passed requirement has an error!');
		$this->assertEquals(false, $checkedRequirements['requirementPass']['warning'], 'Passed requirement has a warning!');

		$this->assertEquals(true, $checkedRequirements['requirementError']['error'], 'Error requirement has no error!');
	}

	public function testCheckPhpExtensionVersion() {
		$requirementsChecker = new QsRequirementsChecker();

		$this->assertFalse($requirementsChecker->checkPhpExtensionVersion('some_unexisting_php_extension', '0.1'), 'No fail while checking unexisting extension!');

		$this->assertTrue($requirementsChecker->checkPhpExtensionVersion('pdo', '1.0'), 'Unable to check PDO version!');
	}

	/**
	 * Data provider for {@link testGetByteSize()}.
	 * @return array
	 */
	public function dataProviderGetByteSize() {
		return array(
			array('456', 456),
			array('5K', 5*1024),
			array('16KB', 16*1024),
			array('4M', 4*1024*1024),
			array('14MB', 14*1024*1024),
			array('7G', 7*1024*1024*1024),
			array('12GB', 12*1024*1024*1024),
		);
	}

	/**
	 * @dataProvider dataProviderGetByteSize
	 *
	 * @param string $verboseValue verbose value.
	 * @param integer $expectedByteSize expected byte size.
	 */
	public function testGetByteSize($verboseValue, $expectedByteSize) {
		$requirementsChecker = new QsRequirementsChecker();

		$this->assertEquals($expectedByteSize, $requirementsChecker->getByteSize($verboseValue), "Wrong byte size for '{$verboseValue}'!");
	}

	public function dataProviderCompareByteSize() {
		return array(
			array('2M', '2K', '>', true),
			array('2M', '2K', '>=', true),
			array('1K', '1024', '==', true),
			array('10M', '11M', '<', true),
			array('10M', '11M', '<=', true),
		);
	}

	/**
	 * @depends testGetByteSize
	 * @dataProvider dataProviderCompareByteSize
	 *
	 * @param string $a first value.
	 * @param string $b second value.
	 * @param string $compare comparison.
	 * @param boolean $expectedComparisonResult expected comparison result.
	 */
	public function testCompareByteSize($a, $b, $compare, $expectedComparisonResult) {
		$requirementsChecker = new QsRequirementsChecker();
		$this->assertEquals($expectedComparisonResult, $requirementsChecker->compareByteSize($a, $b, $compare), "Wrong compare '{$a}{$compare}{$b}'");
	}

	public function testCheckShellCommandAvailable() {
		$requirementsChecker = new QsRequirementsChecker();

		$this->assertTrue($requirementsChecker->checkShellCommandAvailable('ls'), 'Existing shell command check failed!');
		$this->assertFalse($requirementsChecker->checkShellCommandAvailable('test_unexisting_shell_command'), 'Unexisting shell command check failed!');
	}
}
