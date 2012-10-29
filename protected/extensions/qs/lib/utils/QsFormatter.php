<?php
/**
 * QsFormatter class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2012 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

/**
 * Extension of the standard Yii class {@link CFormatter},
 * which extends format methods list with the following features:
 * - format date/time given as string for {@link strtotime}
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.utils
 */
class QsFormatter extends CFormatter {

	/**
	 * Checks if the date time value given as string or timestamp.
	 * If value is timestamp its integer value will be returned.
	 * If value is a string it will be passed to {@link strtotime} to create a timestamp.
	 * @param mixed $value the value to be formatted: UNIX timestamp or a string in strtotime format
	 * @return int the timestamp of value
	 */
	protected function normalizeDateTimeValue($value) {
		if (is_string($value)) {
			if (ctype_digit($value)) {
				$value = (int)$value;
			} else {
				$value = strtotime($value);
			}
		}
		return $value;
	}

	/**
	 * Formats the value as a date.
	 * @param mixed $value the value to be formatted: UNIX timestamp or a string in strtotime format
	 * @param mixed $format determines result format, if empty - default will be used
	 * @return string the formatted result
	 * @see dateFormat
	 */
	public function formatStrDate($value, $format=null) {
		if (empty($format)) {
			$format = $this->dateFormat;
		}
		$value = $this->normalizeDateTimeValue($value);
		return date($format, $value);
	}

	/**
	 * Formats the value as a time.
	 * @param mixed $value the value to be formatted: UNIX timestamp or a string in strtotime format
	 * @param mixed $format determines result format, if empty - default will be used
	 * @return string the formatted result
	 * @see timeFormat
	 */
	public function formatStrTime($value, $format=null) {
		if (empty($format)) {
			$format = $this->timeFormat;
		}
		$value = $this->normalizeDateTimeValue($value);
		return date($format, $value);
	}

	/**
	 * Formats the value as a date and time.
	 * @param mixed $value the value to be formatted: UNIX timestamp or a string in strtotime format
	 * @param mixed $format determines result format, if empty - default will be used
	 * @return string the formatted result
	 * @see datetimeFormat
	 */
	public function formatStrDateTime($value, $format=null) {
		if (empty($format)) {
			$format = $this->datetimeFormat;
		}
		$value = $this->normalizeDateTimeValue($value);
		return date($format, $value);
	}

	/**
	 * Formats the value evaluating it as PHP expression.
	 * @param mixed $value the value to be formatted: a PHP expression or PHP callback to be evaluated.
	 * @param array $_data_ additional parameters to be passed to the above expression/callback.
	 * @return string the formatted result
	 */
	public function formatEval($value, $data=array()) {
		return $this->evaluateExpression($value, $data);
	}

	/**
	 * Formats the value evaluating it as view file content.
	 * @param mixed $value the value to be formatted: view code (HTNL with embeded PHP).
	 * @param array $_data_ additional parameters to be passed to the above expression/callback.
	 * @return string the formatted result
	 */
	public function formatEvalView($value, $data=null) {
		return $this->evalRender($value, $data);
	}

	/**
	 * Evaluates string as view file content.
	 * @param string $_viewStr_ - code to be evaluated.
	 * @param array $_data_ - list of parameters to be parsed.
	 * @return string result of evaluation.
	 */
	protected function evalRender($_viewStr_, array $_data_=null) {
		$_evalStr_ = '?>'.$_viewStr_;
		if (is_array($_data_)) {
			extract($_data_,EXTR_PREFIX_SAME,'data');
		}
		ob_start();
		ob_implicit_flush(false);
		eval($_evalStr_);
		return ob_get_clean();
	}
}