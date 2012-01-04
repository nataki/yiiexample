<?php
/**
 * This is the main Web application configuration. Any writable
 * CWebApplication properties can be configured here.
 */

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
        'components'=>array(
            'user'=>array(
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
                'loginUrl'=>array('/site/login'),
            ),
            'session' => array(
                'sessionName' => 'yiiExampleSession',
                'autoStart' => true                
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                'rules'=>array(
                    '/'=>'site/index',
                    array(
                        'class'=>'ext.qs.url.QsUrlRuleModelPage'
                    ),
                    array(
                        'class'=>'ext.qs.url.QsUrlRuleModuleDefault'
                    ),
                    '<controller:\w+>/<id:\d+>*'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>*'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>*'=>'<controller>/<action>',
                ),
            )
        ),
    )
);