<?php

/**
 * Test case for the extension "ext.qs.lib.utils.QsFormatter".
 * @see QsFormatter
 */
class QsFormatterTest extends CTestCase {

	public static function setUpBeforeClass() {
		Yii::import('ext.qs.lib.utils.QsFormatter');
	}

	public function testFormatStrDate() {
		$formatter = new QsFormatter();

		$dateString = 'NOW +'.rand(0, 30).' days';
		$dateTimestamp = strtotime($dateString);

		$expectedFormattedDate = date($formatter->dateFormat, $dateTimestamp);
		$formattedDate = $formatter->formatStrDate($dateString);
		$this->assertEquals( $formattedDate, $expectedFormattedDate, 'Unable to format date from string!' );
		$formattedDate = $formatter->formatStrDate($dateTimestamp);
		$this->assertEquals( $formattedDate, $expectedFormattedDate, 'Unable to format date from timestamp!' );

		$customFormat = 'Y|m|d';
		$expectedFormattedDate = date($customFormat, $dateTimestamp);
		$formattedDate = $formatter->formatStrDate($dateString, $customFormat);
		$this->assertEquals( $formattedDate, $expectedFormattedDate, 'Unable to format date from string with custom format!' );
	}

	public function testFormatStrTime() {
		$formatter = new QsFormatter();

		$dateString = 'NOW +'.rand(0, 30).' days';
		$dateTimestamp = strtotime($dateString);

		$expectedFormattedTime = date($formatter->timeFormat, $dateTimestamp);
		$formattedTime = $formatter->formatStrTime($dateString);
		$this->assertEquals( $formattedTime, $expectedFormattedTime, 'Unable to format time from string!' );
		$formattedTime = $formatter->formatStrTime($dateTimestamp);
		$this->assertEquals( $formattedTime, $expectedFormattedTime, 'Unable to format time from timestamp!' );

		$customFormat = 'H|i|s';
		$expectedFormattedTime = date($customFormat, $dateTimestamp);
		$formattedTime = $formatter->formatStrTime($dateString, $customFormat);
		$this->assertEquals( $formattedTime, $expectedFormattedTime, 'Unable to format time from string with custom format!' );
	}

	public function testFormatStrDateTime() {
		$formatter = new QsFormatter();

		$dateString = 'NOW +'.rand(0, 30).' days';
		$dateTimestamp = strtotime($dateString);

		$expectedFormattedDateTime = date($formatter->datetimeFormat, $dateTimestamp);
		$formattedDateTime = $formatter->formatStrDateTime($dateString);
		$this->assertEquals( $formattedDateTime, $expectedFormattedDateTime, 'Unable to format datetime from string!' );
		$formattedDateTime = $formatter->formatStrDateTime($dateTimestamp);
		$this->assertEquals( $formattedDateTime, $expectedFormattedDateTime, 'Unable to format datetime from timestamp!' );

		$customFormat = 'Y|m|d H|i|s';
		$expectedFormattedDateTime = date($customFormat, $dateTimestamp);
		$formattedDateTime = $formatter->formatStrDateTime($dateString, $customFormat);
		$this->assertEquals( $formattedDateTime, $expectedFormattedDateTime, 'Unable to format datetime from string with custom format!' );
	}

	public function testFormatEval() {
		$formatter = new QsFormatter();

		$phpCode = "trim(' test ');";

		$formattedValue = $formatter->formatEval($phpCode);
		$expectedFormattedValue = eval('return '.$phpCode);

		$this->assertEquals($formattedValue, $expectedFormattedValue, 'Unable to perform format eval!');
	}

	public function testFormatEvalView() {
		$formatter = new QsFormatter();

		$testExpressionPattern = '<h1>Test var = "{value}"</h1>';
		$testValue = 'Test value';
		$testExpression = str_replace('{value}', '<?php echo("'.$testValue.'"); ?>', $testExpressionPattern);

		$expectedFormatResult = str_replace('{value}', $testValue, $testExpressionPattern);

		$formatResult = $formatter->formatEvalView($testExpression);

		$this->assertEquals($expectedFormatResult, $formatResult, 'Unable to perform format eval of view!');
	}
}
