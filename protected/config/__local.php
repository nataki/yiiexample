<?php
/**
 * Any application properties, which should vary for different application copies
 * should be placed here.
 */

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if (!isset($_SERVER['HTTP_HOST'])) {
    // Mockup HTTP params for the console application:
    $host = 'debug.quart-soft.com';
    $documentRoot = '/home/www/debug/html';
    $projectRoot = '/pklimov/yiiexample';
    $scriptName = $projectRoot.'/index.php';
    
    $_SERVER['HTTP_HOST'] = $host;
    $_SERVER['REQUEST_URI'] = $projectRoot.'/';
    $_SERVER['SCRIPT_NAME'] = $scriptName;
    $_SERVER['SCRIPT_FILENAME'] = $documentRoot.$scriptName;
    $_SERVER['PHP_SELF'] = $scriptName;
    $_SERVER['DOCUMENT_ROOT'] = $documentRoot;
}

return array(
    // application components
    'components'=>array(        
        'db'=>array(
            'connectionString'=>'mysql:host=localhost;dbname=yiiexample',
            'emulatePrepare'=>true,
            'username'=>'devel',
            'password'=>'admin4mysql',
            'charset'=>'utf8',
            //'schemaCachingDuration' => 3600,
            //'enableParamLogging' => true,
            //'enableProfiling' => true,            
        ),
        'cache'=>array(
            'servers'=>array(
                array(
                    'host'=>'localhost', 
                    'port'=>11211,
                    'weight'=>100
                ),
            ),
        ),        
        'log'=>array(            
            'routes'=>array(                
                // uncomment the following to show log messages on web pages
                /*array(
                    'class'=>'CWebLogRoute',
                ),*/
                // uncomment the following to recieve log messages via email
                /*array(
                    'class'=>'CEmailLogRoute',
                    'email'=>array(
                        'pklimov@quart-soft.com'
                    ),
                    'levels'=>'error',
                ),*/
            ),                
        ),
        // uncomment the following to set up email test mode
        /*'email'=>array(
            'testMode' => 'bcc',
            'testEmail' => 'pklimov@quart-soft.com',
        ),*/
    ),
    // uncomment the following to enable the web code generator
    /*'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'ipFilters'=>array(
                '127.0.0.1',
                '10.10.50.60'
            ),
            'password'=>'admin4gii',
            'generatorPaths'=>array(
                'ext.qs.gii'
            ),
        ),            
    ),*/
);