<?php
/**
 * This is an entry point for the main application. 
 */

// change the following paths if necessary
$localConfig = require_once(dirname(__FILE__).'/protected/config/local.php');
require_once(dirname(__FILE__).'/framework/yii.php');
$config = require_once(dirname(__FILE__).'/protected/config/index.php');

Yii::createWebApplication($config)->run();
