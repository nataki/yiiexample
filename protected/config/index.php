<?php

$project_root = dirname(dirname(__FILE__));
$project_mode = basename(__FILE__, ".php");

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'controllerPath' => $project_root.'/controllers/'.$project_mode,
        'viewPath' => $project_root.'/views/'.$project_mode,
        'import' => array(
            'application.components.index.*'
        ),
        'onBeginRequest'=>array('AppEventHandler', 'onBeginRequest'),
        
        'components'=>array(
            'user'=>array(
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
                'loginUrl'=>array('/login'),
            ),
            'session' => array(
                'sessionName' => 'yiiExampleSession',
                'autoStart' => true                
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                'rules'=>array(
                    '<controller:\w+>/<id:\d+>*'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>*'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>*'=>'<controller>/<action>',
                    //'<controller:\w+>'=>'<controller>',
                    //'<action:\w+>*'=>'site/<action>',
                ),
            )
        ),
    )
);