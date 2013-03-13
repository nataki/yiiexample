<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$localConfig = require_once(dirname(__FILE__).'/protected/config/local.php');
require_once(dirname(__FILE__).'/framework/yii.php');
$config = require_once(dirname(__FILE__).'/protected/config/test.php');

Yii::createWebApplication($config)->run();
