<?php

return array(
    // application components
    'components'=>array(        
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=yii_example',
            'emulatePrepare' => true,
            'username' => 'devel',
            'password' => 'admin4mysql',
            'charset' => 'utf8',
            //'enableParamLogging' => true
        ),
        
    ),
);