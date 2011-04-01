<?php

$project_root = dirname(dirname(__FILE__));
$project_mode = basename(__FILE__, ".php");

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'controllerPath' => $project_root.'/controllers/'.$project_mode,
        'viewPath' => $project_root.'/views/'.$project_mode,
        'import' => array(
            'application.components.admin.*'            
        ),
        
        'modules'=>array(
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'ipFilters'=>array(
                    '127.0.0.1',
                    '10.10.50.60'
                ),
                'password'=>'password',
            ),            
        ),        
        
        'components'=>array(
            'user'=>array(
                // enable cookie-based authentication
                'allowAutoLogin'=>false,
                'loginUrl'=>array('/site/login'),
            ),
            'session' => array(
                'sessionName' => 'yiiExampleSessionAdmin',
                'autoStart' => true                
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>true,
                'rules'=>array(
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            )
        ),
    )
);