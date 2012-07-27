<?php
 
class ForgotPasswordForm extends CFormModel {
	public $email;
	public $verifyCode;

	/**
	 * Initializes this model.
	 */
	public function init() {
		if (!Yii::app()->user->getIsGuest()) {
			$this->email = Yii::app()->user->email;
		}
	}

	/**
	 * Declares the validation rules.
	 * @return array validation rules.
	 */
	public function rules() {
		return array(
			array('email', 'required'),
			array('email', 'email'),
			array('verifyCode', 'captcha', 'allowEmpty'=>( !Yii::app()->user->getIsGuest() || !CCaptcha::checkRequirements() ) ),
		);
	}

	/**
	 * Finds the user by email and resets his password.
	 * @param boolean $runValidation whether to perform validation before saving the record.
	 * If the validation fails, the record will not be saved to database.
	 * @return boolean success.
	 */
	public function resetPassword($runValidation=true) {
		if (!$runValidation || $this->validate()) {
			$attributes = array(
				'email' => $this->email
			);
			$member = Member::model()->findByAttributes($attributes);
			if (is_object($member)) {
				$member->resetPassword();
				return true;
			} else {
				$this->addError('email', 'Such email address does not registered.');
				return false;
			}
		} else {
			return false;
		}
	}
}
