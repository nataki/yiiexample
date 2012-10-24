<?php
/**
 * This is the administration panel application configuration. Any writable
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
			'application.components.admin.*'
		),
		'components' => array(
			'user' => array(
				// enable cookie-based authentication
				'allowAutoLogin' => false,
				'loginUrl' => array('/site/login'),
				'behaviors' => array(
					'modelBehavior' => array(
						'modelClassName' => 'Administrator'
					),
				),
			),
			'session' => array(
				'sessionName' => 'yiiExampleSessionAdmin',
				'autoStart' => true
			),
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => true,
				'rules' => array(
					'/' => 'site/index',
					array(
						'class' => 'ext.qs.lib.web.url.QsUrlRuleModuleDefault'
					),
					'<controller:\w+>/<id:\d+>*' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>*' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>/*' => '<controller>/<action>',
				),
			)
		),
	)
);