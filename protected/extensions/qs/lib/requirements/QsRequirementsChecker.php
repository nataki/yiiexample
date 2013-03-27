<?php
/**
 * QsRequirementsChecker class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2013 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

if (version_compare(PHP_VERSION, '4.3', '<')) {
	echo 'At least PHP 4.3 is required';
	exit(1);
}

/**
 * QsRequirementsChecker allows checking if current system meets the requirements for running application.
 * This class allows rendering check report for the web and console application interface.
 *
 * Example:
 * <code>
 * require_once('path/to/QsRequirementsChecker.php');
 * $requirementsChecker = QsRequirementsChecker();
 * $requirements = array(
 *     array(
 *         'name' => 'PHP Some Extension',
 *         'mandatory' => true,
 *         'condition' => extension_loaded('some_extension'),
 *         'by' => 'Some application feature',
 *         'memo' => 'PHP extension "some_extension" required',
 *     ),
 * );
 * $requirementsChecker->render($requirements);
 * <code>
 *
 * QsRequirementsChecker provides internal requirements (see file "requirements.php"),
 * which will be always checked along with the given ones.
 * Each default requirement has a key, which allows you to override it.
 * For example:
 * <code>
 * require_once('path/to/QsRequirementsChecker.php');
 * $requirementsChecker = QsRequirementsChecker();
 * $requirements = array(
 *     'phpVersion' => array(
 *         'condition' => version_compare(PHP_VERSION, '5.4.0', '>='),
 *         'memo' => 'PHP 5.4.0 or higher is required.',
 *     ),
 * );
 * $requirementsChecker->render($requirements);
 * <code>
 *
 * Requirement condition could be in format "eval:PHP expression".
 * In this case specified PHP expression will be evaluated in the context of this class instance.
 * For example:
 * <code>
 * $requirements = array(
 *     array(
 *         'name' => 'Upload max file size',
 *         'condition' => 'eval:$this->checkUploadMaxFileSize("5M")',
 *     ),
 * );
 * </code>
 *
 * If you want to perform requirements checking without rendering default report, you may use {@link check()}.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.requirements
 */
class QsRequirementsChecker {
	/**
	 * Returns the default requirements.
	 * @return array default requirements.
	 */
	function getDefaultRequirements() {
		return require(dirname(__FILE__).DIRECTORY_SEPARATOR.'requirements.php');
	}

	/**
	 * Check the given requirements
	 * @param array $requirements  requirements to be checked.
	 * @return array check result in format:
	 * <code>
	 * array(
	 *     'summary' => array(
	 *         'total' => total number of checks,
	 *         'errors' => number of errors,
	 *         'warnings' => number of warnings,
	 *     ),
	 *     'requirements' => array(
	 *         array(
	 *             ...
	 *             'error' => is there an error,
	 *             'warning' => is there a warning,
	 *         ),
	 *         ...
	 *     ),
	 * )
	 * </code>
	 */
	function check($requirements) {
		if (!is_array($requirements)) {
			$this->usageError("Requirements must be an array!");
		}
		$requirements = $this->mergeArray($this->getDefaultRequirements(), $requirements);

		$summary = array(
			'total' => 0,
			'errors' => 0,
			'warnings' => 0,
		);
		foreach ($requirements as $key => $rawRequirement) {
			$requirement = $this->normalizeRequirement($rawRequirement, $key);

			$summary['total']++;
			if (!$requirement['condition']) {
				if ($requirement['mandatory']) {
					$requirement['error'] = true;
					$requirement['warning'] = true;
					$summary['errors']++;
				} else {
					$requirement['error'] = false;
					$requirement['warning'] = true;
					$summary['warnings']++;
				}
			} else {
				$requirement['error'] = false;
				$requirement['warning'] = false;
			}
			$requirements[$key] = $requirement;
		}
		$result = array(
			'summary' => $summary,
			'requirements' => $requirements,
		);
		return $result;
	}

	/**
	 * Renders the requirements check result.
	 * The output will vary depending is a script running from web or from console.
	 * @param array $requirements requirements to be checked.
	 */
	function render($requirements) {
		$checkResult = $this->check($requirements);
		$this->renderCheckResult($checkResult);
	}

	/**
	 * Renders the result of {@link render()}.
	 * @param array $checkResult requirements check result.
	 */
	function renderCheckResult($checkResult) {
		$baseViewFilePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'views';
		if (array_key_exists('argv', $_SERVER)) {
			$viewFileName = $baseViewFilePath.DIRECTORY_SEPARATOR.'console'.DIRECTORY_SEPARATOR.'index.php';
		} else {
			$viewFileName = $baseViewFilePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'index.php';
		}
		$this->renderViewFile($viewFileName, $checkResult);
	}

	/**
	 * Merges two or more arrays into one recursively.
	 * If each array has an element with the same string key value, the latter
	 * will overwrite the former (different from array_merge_recursive).
	 * Recursive merging will be conducted if both arrays have an element of array
	 * type and are having the same key.
	 * For integer-keyed elements, the elements from the latter array will
	 * be appended to the former array.
	 * @param array $a array to be merged to
	 * @param array $b array to be merged from. You can specifiy additional
	 * arrays via third argument, fourth argument etc.
	 * @return array the merged array (the original arrays are not changed.)
	 * @see mergeWith
	 */
	function mergeArray($a, $b) {
		$args = func_get_args();
		$res = array_shift($args);
		while (!empty($args)) {
			$next = array_shift($args);
			foreach ($next as $k => $v) {
				if (is_integer($k)) {
					isset($res[$k]) ? $res[]=$v : $res[$k]=$v;
				} elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
					$res[$k] = $this->mergeArray($res[$k], $v);
				} else {
					$res[$k] = $v;
				}
			}
		}
		return $res;
	}

	/**
	 * Renders a view file.
	 * This method includes the view file as a PHP script
	 * and captures the display result if required.
	 * @param string $_viewFile_ view file
	 * @param array $_data_ data to be extracted and made available to the view file
	 * @param boolean $_return_ whether the rendering result should be returned as a string
	 * @return string the rendering result. Null if the rendering result is not required.
	 */
	function renderViewFile($_viewFile_, $_data_=null, $_return_=false) {
		// we use special variable names here to avoid conflict when extracting data
		if (is_array($_data_)) {
			extract($_data_, EXTR_PREFIX_SAME, 'data');
		} else {
			$data = $_data_;
		}
		if ($_return_) {
			ob_start();
			ob_implicit_flush(false);
			require($_viewFile_);
			return ob_get_clean();
		} else {
			require($_viewFile_);
		}
	}

	/**
	 * Normalizes requirement ensuring it has correct format.
	 * @param array $requirement raw requirement.
	 * @param int $requirementKey requirement key in the list.
	 * @return array normalized requirement.
	 */
	function normalizeRequirement($requirement, $requirementKey=0) {
		if (!is_array($requirement)) {
			$this->usageError('Requirement must be an array!');
		}
		if (!array_key_exists('condition', $requirement)) {
			$this->usageError("Requirement '{$requirementKey}' has no condition!");
		} else {
			$evalPrefix = 'eval:';
			if (is_string($requirement['condition']) && strpos($requirement['condition'], $evalPrefix)===0) {
				$expression = substr($requirement['condition'], strlen($evalPrefix));
				$requirement['condition'] = $this->evaluateExpression($expression);
			}
		}
		if (!array_key_exists('name', $requirement)) {
			$requirement['name'] = is_numeric($requirementKey) ? 'Requirement #'.$requirementKey : $requirementKey;
		}
		if (!array_key_exists('mandatory', $requirement)) {
			if (array_key_exists('required', $requirement)) {
				$requirement['mandatory'] = $requirement['required'];
			} else {
				$requirement['mandatory'] = false;
			}
		}
		if (!array_key_exists('by', $requirement)) {
			$requirement['by'] = 'Unknown';
		}
		if (!array_key_exists('memo', $requirement)) {
			$requirement['memo'] = '';
		}
		return $requirement;
	}

	/**
	 * Displays a usage error.
	 * This method will then terminate the execution of the current application.
	 * @param string $message the error message
	 */
	function usageError($message) {
		echo "Error: $message\n\n";
		exit(1);
	}

	/**
	 * Evaluates a PHP expression under the context of this class.
	 * @param string $expression a PHP expression to be evaluated.
	 * @return mixed the expression result
	 */
	function evaluateExpression($expression) {
		return eval('return '.$expression.';');
	}

	/**
	 * Returns the server information.
	 * @return string server information.
	 */
	function getServerInfo() {
		$info = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';
		return $info;
	}

	/**
	 * Returns the now date if possible in string representation.
	 * @return string now date.
	 */
	function getNowDate() {
		$nowDate = @strftime('%Y-%m-%d %H:%M', time());
		return $nowDate;
	}

	/**
	 * Checks if Yii captcha is supported.
	 * @return boolean success.
	 */
	function checkCaptchaSupport() {
		if (extension_loaded('imagick')) {
			$imagick = new Imagick();
			$imagickFormats = $imagick->queryFormats('PNG');
		}
		if (extension_loaded('gd')) {
			$gdInfo = gd_info();
		}
		if (isset($imagickFormats) && in_array('PNG', $imagickFormats)) {
			return true;
		} elseif (isset($gdInfo)) {
			if ($gdInfo['FreeType Support']) {
				return true;
			}
			// GD installed,<br />FreeType support not installed
			return false;
		}
		// GD or ImageMagick not installed
		return false;
	}

	/**
	 * Checks if the given PHP extension is available and its version matches the given one.
	 * @param string $extensionName PHP extension name.
	 * @param string $version required PHP extension version.
	 * @param string $compare comparison operator, by default '>='
	 * @return boolean if PHP extension version matches.
	 */
	function checkPhpExtensionVersion($extensionName, $version, $compare='>=') {
		if (!extension_loaded($extensionName)) {
			return false;
		}
		$extensionVersion = phpversion($extensionName);
		if (empty($extensionVersion)) {
			return false;
		}
		return version_compare($extensionVersion, $version, $compare);
	}

	/**
	 * Checks if PHP configuration option (from php.ini) is on.
	 * @param string $name configuration option name.
	 * @return boolean option is on.
	 */
	function checkPhpIniOn($name) {
		$value = ini_get($name);
		if (empty($value)) {
			return false;
		}
		return ((integer)$value==1 || strtolower($value) == 'on');
	}

	/**
	 * Checks if PHP configuration option (from php.ini) is off.
	 * @param string $name configuration option name.
	 * @return boolean option is off.
	 */
	function checkPhpIniOff($name) {
		$value = ini_get($name);
		if (empty($value)) {
			return true;
		}
		return (strtolower($value) == 'off');
	}

	/**
	 * Compare byte sizes of values given in the verbose representation,
	 * like '5M', '15K' etc.
	 * @param string $a first value.
	 * @param string $b second value.
	 * @param string $compare comparison operator, by default '>='.
	 * @return boolean comparison result.
	 */
	function compareByteSize($a, $b, $compare='>=') {
		$compareExpression = '('.$this->getByteSize($a).$compare.$this->getByteSize($b).')';
		return $this->evaluateExpression($compareExpression);
	}

	/**
	 * Gets the size in bytes from verbose size representation.
	 * For example: '5K' => 5*1024
	 * @param string $verboseSize verbose size representation.
	 * @return integer actual size in bytes.
	 */
	function getByteSize($verboseSize) {
		if (empty($verboseSize)) {
			return 0;
		}
		if (is_numeric($verboseSize)) {
			return (integer)$verboseSize;
		}
		$sizeUnit = trim($verboseSize, '0123456789');
		$size = str_replace($sizeUnit, '', $verboseSize);
		$size = trim($size);
		if (!is_numeric($size)) {
			return 0;
		}
		switch (strtolower($sizeUnit)) {
			case 'kb':
			case 'k': {
				return $size*1024;
			}
			case 'mb':
			case 'm': {
				return $size*1024*1024;
			}
			case 'gb':
			case 'g': {
				return $size*1024*1024*1024;
			}
			default: {
				return 0;
			}
		}
	}

	/**
	 * Checks if upload max file size matches give range.
	 * @param string|null $min verbose file size minimum required value, pass null to skip minimum check.
	 * @param string|null $max verbose file size maximum required value, pass null to skip maximum check.
	 * @return boolean success.
	 */
	function checkUploadMaxFileSize($min=null, $max=null) {
		$postMaxSize = ini_get('post_max_size');
		$uploadMaxFileSize = ini_get('upload_max_filesize');
		if ($min!==null) {
			$minCheckResult = $this->compareByteSize($postMaxSize, $min, '>=') && $this->compareByteSize($uploadMaxFileSize, $min, '>=');
		} else {
			$minCheckResult = true;
		}
		if ($max!==null) {
			var_dump($postMaxSize, $uploadMaxFileSize, $max);
			$maxCheckResult = $this->compareByteSize($postMaxSize, $max, '<=') && $this->compareByteSize($uploadMaxFileSize, $max, '<=');
		} else {
			$maxCheckResult = true;
		}
		return ($minCheckResult && $maxCheckResult);
	}

	/**
	 * Checks if given shell command available via "exec".
	 * Warning: this check could be unreliable! It attempts to invoke shell command
	 * with '--help' option. If no such option available the check will fail.
	 * @param string $commandName shell command name
	 * @return boolean success.
	 */
	function checkShellCommandAvailable($commandName) {
		$output = array();
		$returnStatus = null;
		exec($commandName.' --help', $output, $returnStatus);
		return (!empty($output) || $returnStatus==0);
	}
}
