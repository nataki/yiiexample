<?php
/**
 * This is the main Web application configuration. Any writable
 * CWebApplication properties can be configured here.
 */

$projectRoot = dirname(dirname(__FILE__));
$projectMode = basename(__FILE__, ".php");

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'controllerPath' => $projectRoot.'/controllers/'.$projectMode,
		'viewPath' => $projectRoot.'/views/'.$projectMode,
		'import' => array(
			'application.components.index.*'
		),
		'components' => array(
			'user' => array(
				// enable cookie-based authentication
				'allowAutoLogin' => true,
				'loginUrl' => array('/site/login'),
				'behaviors' => array(
					'modelBehavior' => array(
						'modelClassName' => 'Member'
					),
				),
			),
			'externalAuth' => array(
				'class' => 'ext.qs.lib.web.auth.external.QsAuthExternalServiceCollection',
				'services' => array(
					'googleOpenId' => array(
						'class' => 'QsAuthExternalServiceGoogleOpenId',
						'requiredAttributes' => array(
							'first_name' => 'namePerson/first',
							'last_name' => 'namePerson/last',
							'email' => 'contact/email',
							'language' => 'pref/language',
						),
					),
					'googleOAuth' => array(
						'class' => 'QsAuthExternalServiceGoogleOAuth',
						'oAuthClient' => array(
							'clientId' => '214767141763.apps.googleusercontent.com',
							'clientSecret' => 'f5JwoEMgPlzdqa6uOhWKYOH6',
						),
					),
					'twitter' => array(
						'class' => 'QsAuthExternalServiceTwitterOAuth',
						'oAuthClient' => array(
							'consumerKey' => 'B8Yx1BewS3a0klA1e6lWEw',
							'consumerSecret' => 'ZKECSMGU6vmc4FYJ09Hk0VIOYtWYKSBKr4WrlOveLTc',
						),
					),
					'facebook' => array(
						'class' => 'QsAuthExternalServiceFacebookOAuth',
						'oAuthClient' => array(
							'clientId' => '344210389040383',
							'clientSecret' => 'f81cd7421e7482e0300316554957f3aa',
						),
					),
				),
			),
			'session' => array(
				'sessionName' => 'yiiExampleSession',
				'autoStart' => true
			),
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
				'rules' => array(
					'/' => 'site/index',
					array(
						'class' => 'ext.qs.lib.web.url.QsUrlRuleModelPage'
					),
					array(
						'class' => 'ext.qs.lib.web.url.QsUrlRuleModuleDefault'
					),
					'<controller:\w+>/<id:\d+>*' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>*' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>*' => '<controller>/<action>',
				),
			)
		),
	)
);