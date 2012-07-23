<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../framework/yiic.php';
// Adjust the application configuration if necessary
$config=array(
    'basePath'=>dirname(__FILE__),
    'name'=>'YiiExample Install',
    'commandMap'=>array(
        'install'=>array(
            'class'=>'ext.qs.console.commands.QsConsoleCommandInitApplication',
			'localFilePlaceholderLabels'=>array(
				// Database:
				'dbHost'=>'Database hostname, usually: "localhost"',
				'dbName'=>'Database name',
				'dbUser'=>'Database access user name',
				'dbPassword'=>'Database access password',
				// URL:
				'hostInfo'=>'URL for the web server root',
				'baseUrl'=>'Part of the URL, which leads for the project web root. At the live server it is usually "/"',
			),
			'localFilePlaceholderDefaultValues'=>array(
				// Database:
				'dbHost'=>'mysql.qs.quart-soft.com',
				'dbName'=>'yiiexample',
				'dbUser'=>'devel',
				//'dbPassword'=>'???',
				// URL:
				'hostInfo'=>'http://dev53.quartsoft.com',
				'baseUrl'=>'/develqs/yiiexample',
			),
        ),
    ),
);

require_once($yiic);

