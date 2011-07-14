<?php
/**
 * This is an entry point for the application administration panel.
 */

// change the following paths if necessary
$localConfig = require_once( dirname(__FILE__).'/protected/config/local.php' );
require_once( dirname(__FILE__).'/framework/yii.php' );
$config = require_once( dirname(__FILE__).'/protected/config/admin.php' );

Yii::createWebApplication($config)->run();
