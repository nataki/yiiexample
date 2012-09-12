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
						'class' => 'ext.qs.web.url.QsUrlRuleModelPage'
					),
					array(
						'class' => 'ext.qs.web.url.QsUrlRuleModuleDefault'
					),
					'<controller:\w+>/<id:\d+>*' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>*' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>*' => '<controller>/<action>',
				),
			)
		),
	)
);