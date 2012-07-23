<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../framework/yiic.php';
// Adjust the application configuration if necessary
$config=array(
	'basePath'=>dirname(__FILE__),
	'name'=>'YiiExample Install',
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
	'components'=>array(
		'log'=>array(
			'routes'=>array(
				array(
					'class'=>'CEmailLogRoute',
					'levels'=>'error',
					'emails'=>array(
						'develqs@quartsoft.com'
					),
					'subject'=>'Application install error at '.exec('hostname'),
					'sentFrom'=>'yiiexample@quartsoft.com',
				),
				array(
					'class'=>'CFileLogRoute',
					'logFile'=>'install.log',
					'categories'=>'qs.console.*',
				),
			),
		),
	),
);

require_once($yiic);

