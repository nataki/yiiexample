<?php
/**
 * This is the administration panel application configuration. Any writable
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
            'application.components.admin.*'            
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
                    '/'=>'site/index',
                    'imaget'=>'imaget',
                    'imaget/<controller:\w+>'=>'imaget/<controller>',
                    'imaget/<controller:\w+>/<action:\w+>*'=>'imaget/<controller>/<action>',
                    /*'imagetranslation'=>'imagetranslation',
                    'imagetranslation/<controller:\w+>'=>'imagetranslation/<controller>',
                    'imagetranslation/<controller:\w+>/<action:\w+>*'=>'imagetranslation/<controller>/<action>',*/
                    array(
                        'class'=>'ext.qs.url.QsUrlRuleModuleDefault'
                    ),
                    '<controller:\w+>/<id:\d+>*'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>*'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
                ),
            )
        ),
    )
);