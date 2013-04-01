<?php
/**
 * This is the list of requirements for the {@link QsRequirementsChecker} instance.
 * These requirements will be merged with the default ones, specified {@link QsRequirementsChecker}.
 */
return array(
	/*array(
		'name' => 'Requirement name',
		'mandatory' => true,
		'condition' => false,
		'by' => 'Some feature',
		'memo' => 'Description',
	),*/
	// Override existing requirements:
	/*'phpVersion' => array(
		'condition' => version_compare(PHP_VERSION, '5.3.3', '>='),
		'memo' => 'PHP 5.3.3 or higher is required.',
	),*/
	/*'db' => array(
		'name' => 'PDO PostgreSQL extension',
		'condition' => extension_loaded('pdo_pgsql'),
		'memo' => 'Required for PostgreSQL database.',
	),*/
	/*'cache' => array(
		'name' => 'APC extension',
		'mandatory' => false,
		'condition' => extension_loaded('apc'),
		'by' => '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
		'memo' => ''
	),*/
	/*'phpMemoryLimit' => array(
		'condition' => 'eval:ini_get("memory_limit")==-1 || $this->compareByteSize(ini_get("memory_limit"),"128M")',
	),*/
	/*'phpUploadMaxFileSize' => array(
		'condition' => 'eval:$this->checkUploadMaxFileSize("5M")',
	),*/
);