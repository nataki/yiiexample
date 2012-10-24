<?php
/**
 * Any application properties, which should vary for different application copies
 * should be placed here.
 */

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// specify error reporting level
error_reporting(E_ALL^E_NOTICE);
ini_set('display_errors', 'on');

// default date timezone
date_default_timezone_set('UTC');

if (!array_key_exists('HTTP_HOST', $_SERVER)) {
	// Mock up HTTP params for the console application:
	$hostInfo = '{{hostInfo}}';
	$baseUrl = '{{baseUrl}}';
	$scriptUrl = $baseUrl.'/index.php';
	$httpRequestConfig = array(
		'hostInfo' => $hostInfo,
		'baseUrl' => $baseUrl,
		'scriptUrl' => $scriptUrl,
	);
} else {
	$httpRequestConfig = array();
}

return array(
	// application components
	'components' => array(
		'request' => $httpRequestConfig,
		'db' => array(
			'connectionString' => 'mysql:host={{dbHost}};dbname={{dbName}}',
			'emulatePrepare' => true,
			'username' => '{{dbUser}}',
			'password' => '{{dbPassword}}',
			'charset' => 'utf8',
			'initSQLs' => array(
				"SET time_zone = '+00:00';"
			),
			//'schemaCachingDuration' => 3600,
			//'enableParamLogging' => true,
			//'enableProfiling' => true,
		),
		'cache' => array(
			'class' => 'system.caching.CMemCache',
			'servers' => array(
				array(
					'host' => 'localhost',
					'port' => 11211,
					'weight' => 100
				),
			),
		),		
		'log' => array(
			'routes' => array(
				// uncomment the following to show log messages on web pages
				/*array(
					'class' => 'CWebLogRoute',
				),*/
				// uncomment the following to receive log messages via email
				/*array(
					'class' => 'CEmailLogRoute',
					'levels' => 'error',
					'emails' => array(
						'develqs@quartsoft.com'
					),
					'subject' => 'Error at '.exec('hostname'),
					'sentFrom' => 'yiiexample@quartsoft.com',
				),*/
			),
		),
		// uncomment the following to set up email test mode
		/*'email' => array(
			'testMode' => 'bcc',
			'testEmail' => 'develqs@quartsoft.com',
		),*/
	),
	'modules' => array(
		// uncomment the following to enable the web code generator
		/*'gii' => array(
			'class' => 'system.gii.GiiModule',
			'ipFilters' => array(
				'127.0.0.1',
				'10.10.50.60'
			),
			'password' => 'admin4gii',
			'generatorPaths' => array(
				'ext.qs.lib.gii'
			),
		),*/
		// uncomment the following to enable the web PHPUnit test runner
		/*'phpunit' => array(
			'class' => 'ext.qs.lib.test.modules.phpunit.PhpunitModule',
			'ipFilters' => array(
				'127.0.0.1',
				'10.10.50.60'
			),
			'password' => 'admin4phpunit',
		),*/
	),
);