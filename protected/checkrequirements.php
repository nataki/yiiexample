<?php
/**
 * Application requirement checker script.
 * List of the requirements to be checked stored in the file "./requirements.php".
 * These requirements will be merged with the default ones, specified {@link QsRequirementsChecker}.
 *
 * In order to run this script use the following console command:
 * php checkrequirements.php
 *
 * In order to run this script from the web, you should copy or create a link to it from the web root.
 * This could be done by following console command:
 * ln checkrequirements.php ../checkrequirements.php
 */

$selfPath = dirname(__FILE__);
if (basename($selfPath) != 'protected') {
	$selfPath .= '/protected';
}
require_once($selfPath.'/extensions/qs/lib/requirements/QsRequirementsChecker.php');
$requirementsChecker = new QsRequirementsChecker();
$requirements = require($selfPath.'/requirements.php');
$requirementsChecker->render($requirements);