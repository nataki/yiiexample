<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../framework/yiic.php';
$config=array(
    'basePath'=>dirname(__FILE__),
    'name'=>'YiiExample Install',
    'commandMap'=>array(
        'install'=>array(
            'class'=>'ext.qs.console.commands.QsConsoleCommandInitApplication',
        ),
    ),
);

require_once($yiic);

