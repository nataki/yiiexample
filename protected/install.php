<?php
/**
 * Application initialization console command entry script.
 *
 * In order to initialize application run the following console command:
 * php install.php init all
 *
 * To get help type:
 * php install.php help init
 *
 * In order to run this script in automatic mode use the following:
 * php install.php init all --interactive=0 --config=/path/to/my/config/init.cfg.php
 */

// Change the following paths if necessary:
$yiic = dirname(__FILE__).'/../framework/yiic.php';
// Adjust the application configuration if necessary:
$config = array(
	'basePath' => dirname(__FILE__),
	'name' => 'YiiExample',
	'commandMap' => array(
		'init' => array(
			'class' => 'ext.qs.lib.console.commands.QsConsoleCommandInitApplication',
			'localFilePlaceholderLabels' => array(
				// Database:
				'dbHost' => 'Database hostname: ip address or domain name, usually: "localhost"',
				'dbName' => 'Database name (make sure such database exists)',
				'dbUser' => 'Database access user name',
				'dbPassword' => 'Database access password',
				// URL:
				'hostInfo' => 'URL for the web server root (domain name with leading protocol)',
				'baseUrl' => 'Part of the URL, which leads for the project web root. At the live server it is usually empty, in development - "/develqs/yiiexample"',
				// Materials:
				'materialsBasePath' => 'Base path for the application dynamic files',
				'materialsBaseUrl' => 'Base URL for the application dynamic files',
				// PHPUnit:
				'phpUnitSeleniumIp' => 'Selenium RC server IP address',
				'phpUnitSeleniumHost' => 'Selenium RC server host name',
			),
			'localFilePlaceholderDefaultValues' => array(
				// Database:
				'dbHost' => 'mysql.qs.quart-soft.com',
				'dbName' => 'yiiexample',
				//'dbUser' => '???',
				//'dbPassword' => '???',
				// URL:
				'hostInfo' => 'http://dev53.quartsoft.com',
				'baseUrl' => '',
				// Materials:
				'materialsBasePath' => '/home/www/debug/materials',
				'materialsBaseUrl' => 'http://materials.quartsoft.com',
				// PHPUnit:
				'phpUnitSeleniumIp' => '10.10.50.60',
				'phpUnitSeleniumHost' => 'pklimov.qs.quart-soft.com',
			),
		),
	),
);

require_once($yiic);
