<?php
/**
 * This is the configuration for generating message translations
 * for the application.
 * It is used by the 'yiic message' command:
 * <pre>
 * php -f yiic message messages/config.php
 * </pre>
 * @see MessageCommand
 */
return array(
	'sourcePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'messagePath' => dirname(__FILE__),
	'languages' => array('en_us'),
	'fileTypes' => array('php'),
	'overwrite' => true,
	'exclude' => array(
		'.svn',
		'.git',
		'/messages',
		'/tests',
	),
);
