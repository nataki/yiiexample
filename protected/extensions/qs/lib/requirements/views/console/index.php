<?php
/* @var $this QsRequirementsChecker */
/* @var $summary array */
/* @var $requirements array[] */

echo "\nApplication Requirement Checker\n\n";

echo "This script checks if your server configuration meets the requirements\n";
echo "for running Web application.\n";
echo "It checks if the server is running the right version of PHP,\n";
echo "if appropriate PHP extensions have been loaded, and if php.ini file settings are correct.\n";

echo "\nConclusion:\n";

$columnSizes = array(
	'name' => 25,
	'condition' => 10,
	'by' => 30,
	'memo' => 50,
);

// Headers:
$tableLength = count($columnSizes)+1;
foreach ($columnSizes as $columnSize) {
	$tableLength += $columnSize;
}
echo str_pad('', $tableLength, '-');
echo "\n";
echo '|'.str_pad('Name', $columnSizes['name'], ' ', STR_PAD_BOTH).'|';
echo str_pad('Result', $columnSizes['condition'], ' ', STR_PAD_BOTH).'|';
echo str_pad('Required By', $columnSizes['by'], ' ', STR_PAD_BOTH).'|';
echo str_pad('Memo', $columnSizes['memo'], ' ', STR_PAD_BOTH).'|';
echo "\n";
echo str_pad('', $tableLength, '-');
echo "\n";

// Rows:
foreach ($requirements as $requirement) {
	$name = $requirement['name'];
	echo '|'.str_pad(' '.$name, $columnSizes['name'], ' ', STR_PAD_RIGHT).'|';
	$condition = $requirement['condition'] ? 'Passed' : ($requirement['mandatory'] ? 'FAILED' : 'WARNING');
	echo str_pad($condition, $columnSizes['condition'], ' ', STR_PAD_BOTH).'|';
	$by = strip_tags($requirement['by']);
	echo str_pad($by, $columnSizes['by'], ' ', STR_PAD_BOTH).'|';
	$memo = strip_tags($requirement['memo']);
	echo str_pad(' '.$memo, $columnSizes['memo'], ' ', STR_PAD_RIGHT).'|';
	echo "\n";
}
echo str_pad('', $tableLength, '-');
echo "\n";

// Summary
$summaryString = 'Errors: '.$summary['errors'].'   Warnings: '.$summary['warnings'].'   Total checks: '.$summary['total'];
$summaryString = str_pad($summaryString, $tableLength, ' ');
if ($summary['errors']>0) {
	echo "\033[0;30m\033[41m".$summaryString."\033[0m";
} elseif ($summary['warnings']>0) {
	echo "\033[0;30m\033[43m".$summaryString."\033[0m";
} else {
	echo "\033[0;30m\033[42m".$summaryString."\033[0m";
}

echo "\n\n";