<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'YiiExample Console Application',
        'commandMap'=>array(
            'migrate'=>array(
                'class'=>'system.cli.commands.MigrateCommand',
                //'migrationPath'=>'application.migrations',
                'migrationTable'=>'_db_migration',
                /*'connectionID'=>'db',
                'templateFile'=>'application.migrations.template',*/
            ),
        ),
    )
);