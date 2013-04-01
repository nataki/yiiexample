<?php
/**
 * This is the default requirements for the {@link QsRequirementsChecker} instance.
 */
return array(
	// Yii core:
	'phpVersion' => array(
		'name' => 'PHP version',
		'mandatory' => true,
		'condition' => version_compare(PHP_VERSION, '5.1.0', '>='),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
		'memo' => 'PHP 5.1.0 or higher is required.',
	),
	'phpReflection' => array(
		'name' => 'Reflection extension',
		'mandatory' => true,
		'condition' => class_exists('Reflection', false),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
	),
	'phpPCRE' => array(
		'name' => 'PCRE extension',
		'mandatory' => true,
		'condition' => extension_loaded('pcre'),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
	),
	'phpSPL' => array(
		'name' => 'SPL extension',
		'mandatory' => true,
		'condition' => extension_loaded('SPL'),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
	),
	'phpDom' => array(
		'name' => 'DOM extension',
		'mandatory' => false,
		'condition' => class_exists('DOMDocument', false),
		'by' => '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>, <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
	),
	'phpPDO' => array(
		'name' => 'PDO extension',
		'mandatory' => true,
		'condition' => extension_loaded('pdo'),
		'by' => 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>',
	),
	'db' => array(
		'name' => 'PDO MySQL extension',
		'mandatory' => true,
		'condition' => extension_loaded('pdo_mysql'),
		'by' => 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>',
		'memo' => 'Required for MySQL database.',
	),
	'cache' => array(
		'name' => 'Memcache extension',
		'mandatory' => false,
		'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
		'by' => '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
		'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a> to <code>true</code>.' : ''
	),
	'phpMcrypt' => array(
		'name' => 'Mcrypt extension',
		'mandatory' => false,
		'condition' => extension_loaded('mcrypt'),
		'by' => '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
		'memo' => 'Required by encrypt and decrypt methods.'
	),
	'captcha' => array(
		'name' => 'Yii Captcha',
		'mandatory' => true,
		'condition' => 'eval:$this->checkCaptchaSupport()',
		'by' => '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
		'memo' => 'GD extension with<br />FreeType support<br />or ImageMagick<br />extension with<br />PNG support'
	),
	// PHP extensions
	'phpMbString' => array(
		'name' => 'Mbstring extension',
		'mandatory' => false,
		'condition' => extension_loaded('mbstring'),
		'by' => '<a href="http://www.php.net/manual/en/book.mbstring.php">Multibyte string</a> processing',
		'memo' => 'Required for multibyte encoding string processing.'
	),
	'phpCurl' => array(
		'name' => 'Curl extension',
		'mandatory' => false,
		'condition' => extension_loaded('curl'),
		'by' => '<a href="http://en.wikipedia.org/wiki/Web_service">Web Services</a> usage',
		'memo' => 'Required if application uses Web Service or performs HTTP requests.'
	),
	'phpSimpleXml' => array(
		'name' => 'SimpleXml extension',
		'mandatory' => false,
		'condition' => extension_loaded('SimpleXml'),
		'by' => 'XML parsing',
		'memo' => 'Required if application parses XML.'
	),
	// PHP ini
	'phpSafeMode' => array(
		'name' => 'PHP safe mode',
		'mandatory' => true,
		'condition' => 'eval:$this->checkPhpIniOff("safe_mode")',
		'by' => 'Application core features',
		'memo' => '"safe_mode" should be disabled at php.ini',
	),
	'phpExposePhp' => array(
		'name' => 'Expose PHP',
		'mandatory' => false,
		'condition' => 'eval:$this->checkPhpIniOff("expose_php")',
		'by' => 'Security reasons',
		'memo' => '"expose_php" should be disabled at php.ini',
	),
	'phpAllowUrlInclude' => array(
		'name' => 'PHP allow url include',
		'mandatory' => false,
		'condition' => 'eval:$this->checkPhpIniOff("allow_url_include")',
		'by' => 'Security reasons',
		'memo' => '"allow_url_include" should be disabled at php.ini',
	),
	'phpSmtp' => array(
		'name' => 'PHP mail SMTP',
		'mandatory' => false,
		'condition' => strlen(ini_get('SMTP'))>0,
		'by' => 'Email sending',
		'memo' => 'PHP mail SMTP server required',
	),
	'phpMemoryLimit' => array(
		'name' => 'PHP memory limit',
		'mandatory' => true,
		'condition' => 'eval:ini_get("memory_limit")==-1 || $this->compareByteSize(ini_get("memory_limit"),"128M")',
		'by' => 'Processing requests',
		'memo' => '"memory_limit" should be at least 5M',
	),
	'phpMaxPostSize' => array(
		'name' => 'Max POST size',
		'mandatory' => true,
		'condition' => 'eval:$this->compareByteSize(ini_get("post_max_size"),"64M")',
		'by' => 'Send POST request',
		'memo' => '"post_max_size" should be at least 64M',
	),
	'phpMaxInputVars' => array(
		'name' => 'Max input vars',
		'mandatory' => false,
		'condition' => (ini_get('max_input_vars')===false) || (ini_get('max_input_vars')>=1000),
		'by' => 'Form submission',
		'memo' => '"max_input_vars" should be at least 1000 at php.ini',
	),
	'phpFileUploads' => array(
		'name' => 'PHP file uploads',
		'mandatory' => false,
		'condition' => 'eval:$this->checkPhpIniOn("file_uploads")',
		'by' => 'Upload files from web',
		'memo' => '"file_uploads" should be enabled at php.ini',
	),
	'phpMaxFileUploads' => array(
		'name' => 'PHP file uploads',
		'mandatory' => false,
		'condition' => ini_get('max_file_uploads')>=20,
		'by' => 'Multiply files upload from web',
		'memo' => '"max_file_uploads" should be at least 20 at php.ini',
	),
	'phpUploadMaxFileSize' => array(
		'name' => 'Upload max file size',
		'mandatory' => false,
		'condition' => 'eval:$this->checkUploadMaxFileSize("5M")',
		'by' => 'File uploading',
		'memo' => '"upload_max_filesize" and "post_max_size" should be at least 5M at php.ini',
	),
	// Shell commands:
	'shellImageMagick' => array(
		'name' => 'Image Magick',
		'mandatory' => false,
		'condition' => 'eval:$this->checkShellCommandAvailable("convert")',
		'by' => 'Image file processing',
		'memo' => '<a href="http://www.imagemagick.org">ImageMagick</a> should be available from shell',
	),
);