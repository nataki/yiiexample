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
 * php install.php init all --interactive=0 --config=/path/to/my/config/install.cfg.php
 */

// Change the following paths if necessary:
$yiic=dirname(__FILE__).'/../framework/yiic.php';
// Adjust the application configuration if necessary:
$config=array(
	'basePath'=>dirname(__FILE__),
	'name'=>'YiiExample',
	'commandMap'=>array(
		'init'=>array(
			'class'=>'ext.qs.console.commands.QsConsoleCommandInitApplication',
			'localFilePlaceholderLabels'=>array(
				// Database:
				'dbHost'=>'Database hostname, usually: "localhost"',
				'dbName'=>'Database name',
				'dbUser'=>'Database access user name',
				'dbPassword'=>'Database access password',
				// URL:
				'hostInfo'=>'URL for the web server root',
				'baseUrl'=>'Part of the URL, which leads for the project web root. At the live server it is usually empty, in development - "/develqs/yiiexample"',
			),
			'localFilePlaceholderDefaultValues'=>array(
				// Database:
				'dbHost'=>'mysql.qs.quart-soft.com',
				'dbName'=>'yiiexample',
				'dbUser'=>'devel',
				//'dbPassword'=>'???',
				// URL:
				'hostInfo'=>'http://dev53.quartsoft.com',
				'baseUrl'=>'',
			),
		),
	),
);

require_once($yiic);
