<?php
/**
 * This is the main application configuration. Any writable
 * CApplication properties can be configured here.
 */

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

return CMap::mergeArray(
	array(
		'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name' => 'YiiExample',

		// preloading 'log' component
		'preload' => array('log'),

		// autoloading model and component classes
		'import' => array(
			'application.models.*',
			'application.models.auth.*',
			'application.models.forms.*',
			'application.models.users.*',
			'application.components.*',
			'ext.qs.email.*'
		),
		'behaviors' => array(
			'siteSetting' => array(
				'class' => 'ext.qs.application.QsApplicationBehaviorParamDb',
				'paramModelClassName' => 'SiteSetting',
			),
			'initFromParam' => array(
				'class' => 'ext.qs.application.QsApplicationBehaviorInitFromParam',
				'propertyParamNames' => array(
					'name' => 'site_name'
				),
			)
		),

		/*'modules' => array(
		),*/

		// application components
		'components' => array(
			'authManager' => array(
				'class' => 'CDbAuthManager',
				'connectionID' => 'db',
				'itemTable' => '_auth_item',
				'itemChildTable' => '_auth_item_child',
				'assignmentTable' => '_auth_assignment',
				'defaultRoles' => array(
					'admin',
					'member'
				)
			),
			'user' => array(
				'class' => 'ext.qs.web.auth.QsWebUser',
				'behaviors' => array(
					'modelBehavior' => array(
						'class' => 'ext.qs.web.auth.QsWebUserBehaviorModelActiveRecord',
						'modelFindCondition' => array(
							'condition' => 'status_id = :status_id',
							'params' => array(
								'status_id' => 2 // active
							),
						),
					),
					'authLogBehavior' => array(
						'class' => 'ext.qs.web.auth.QsWebUserBehaviorAuthLogDb',
					),
				),
			),
			'securityManager' => array(
				'validationKey' => '7ffaf5c32eb73bfb6abcd0ad1b8ebb0c',
				'encryptionKey' => '6f9ad14b1b565543365de229026309c0'
			),
			'errorHandler' => array(
				// use 'site/error' action to display errors
				'errorAction' => 'site/error',
			),
			'cache' => array(
				'class' => 'system.caching.CFileCache',
				// @see protected/config/local.php
			),
			'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
					array(
						'class' => 'CFileLogRoute',
						'levels' => 'error, warning',
					),
					// @see protected/config/local.php
				),
			),
			'format' => array(
				'class' => 'ext.qs.utils.QsFormatter',
				'dateFormat' => 'Y/m/d',
				'timeFormat' => 'H:i:s',
				'datetimeFormat' => 'Y/m/d H:i:s',
			),
			'clientScript' => array(
				'class' => 'ext.qs.web.QsClientScript'
			),
			'email' => array(
				'class' => 'ext.qs.email.QsEmailManager',
				// @see protected/config/local.php
			),
		),
	),
	CMap::mergeArray(
		require(dirname(__FILE__).'/params.php'),
		isset($localConfig) ? $localConfig: require(dirname(__FILE__).'/local.php')
	)
);