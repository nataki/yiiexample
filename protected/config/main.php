<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
    array(
	    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'Yii Example',	    

	    // preloading 'log' component
	    'preload'=>array('log'),

	    // autoloading model and component classes
	    'import'=>array(
            'application.models.*',
		    'application.models.forms.*',
		    'application.components.*',
            'ext.qs.email.*'
	    ),

	    'modules'=>array(
		    // uncomment the following to enable the Gii tool
		    /*'gii'=>array(
			    'class'=>'system.gii.GiiModule',
                'ipFilters'=>array(
                    '127.0.0.1',
                    '10.10.50.60'
                ),
			    'password'=>'password',
		    ),*/		    
	    ),

	    // application components
	    'components'=>array(
		    'authManager'=>array(
                'class'=>'CDbAuthManager',
                'connectionID'=>'db',
                'itemTable' => '_auth_item',
                'itemChildTable' => '_auth_item_child',
                'assignmentTable' => '_auth_assignment',
                'defaultRoles' => array(
                    'admin',
                    'member'
                )
            ),
            'user'=>array(
                'class'=>'ext.qs.auth.QsWebUser',
                'onAfterRestore'=>array('UserIdentity','updateUserStates'),
                'onAfterLogin'=>array('UserIdentity','logLogin')
            ),
            'securityManager'=>array(
                'validationKey'=>'7ffaf5c32eb73bfb6abcd0ad1b8ebb0c',
                'encryptionKey'=>'6f9ad14b1b565543365de229026309c0'
            ),
            'errorHandler'=>array(
			    // use 'site/error' action to display errors
                'errorAction'=>'site/error',
            ),
		    'log'=>array(
			    'class'=>'CLogRouter',
			    'routes'=>array(
				    array(
					    'class'=>'CFileLogRoute',
					    'levels'=>'error, warning',
				    ),
				    // uncomment the following to show log messages on web pages
				    /*array(
					    'class'=>'CWebLogRoute',
				    ),*/
			    ),                
		    ),
            'format'=>array(
                'class'=>'ext.qs.utils.QsFormatter',
                'dateFormat'=>'Y/m/d',
                'timeFormat'=>'H:i:s',
                'datetimeFormat'=>'Y/m/d H:i:s',
            ),
            'email'=>array(
                'class'=>'ext.qs.email.QsEmailManager',
                /*'testMode' => 'bcc',
                'testEmail' => 'pklimov@quart-soft.com',
                'transport' => array(
                    'type' => 'smtp',
                    'host' => 'localhost',
                    'username' => 'username',
                    'password' => 'password',        
                    'port' => '587',
                    'encryption' => 'tls',
                ),*/
            ),
	    ),
    ),
    CMap::mergeArray(
        require(dirname(__FILE__).'/params.php'),
        require(dirname(__FILE__).'/local.php')
    )
);