<?php

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
            'connectionString' => 'mysql:host=localhost;dbname=yiiexample',
            'emulatePrepare' => true,
            'username' => 'devel',
            'password' => 'admin4mysql',
            'charset' => 'utf8',
            //'enableParamLogging' => true
        ),
        
    ),
);