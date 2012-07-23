<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../framework/yiic.php';
$config=array(
    'basePath'=>dirname(__FILE__),
    'name'=>'YiiExample Install',
    'commandMap'=>array(
        'install'=>array(
            'class'=>'ext.qs.console.commands.QsConsoleCommandInitApplication',
			'localFilePlaceholderLabels'=>array(
				'db_host'=>'Database hostname',
				'db_name'=>'Database name',
				'db_user'=>'Database access user name',
				'db_password'=>'Database access password',
			),
			'localFilePlaceholderDefaultValues'=>array(
				'db_host'=>'localhost',
				'db_name'=>'yiiexample',
				'db_user'=>'devel',
				//'db_password'=>'???',
			),
        ),
    ),
);

require_once($yiic);

