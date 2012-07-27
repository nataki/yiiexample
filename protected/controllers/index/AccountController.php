<?php

class AccountController extends IndexController {
	/**
	 * @var string title of the section, varies by action.
	 */
	public $sectionTitle = 'Account';
	/**
	 * @var CActiveRecord stores current user model.
	 */
	protected $_user = null;

	public function setUser(CActiveRecord $user) {
		$this->_user = $user;
		return true;
	}

	public function getUser() {
		$this->initUser();
		return $this->_user;
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		$rules = parent::accessRules();
		// deny anonymous:
		$rules[] = array(
			'deny',
			'users' => array('?'),
		);
		return $rules;
	}

	/**
	 * Initializes the controller.
	 */
	public function init() {
		parent::init();
		$this->layout = "//{$this->id}/layout";

		$this->breadcrumbs = array(
			'Account'=>array($this->getId().'/'),
		);
	}

	/**
	 * Initializes user data based on the session user.
	 * @return boolean success.
	 */
	protected function initUser() {
		if (!is_object($this->_user)) {
			$this->_user = Yii::app()->user->model;
		}
		return true;
	}

	/**
	 * Provides account overview.
	 */
	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * Provides ability to update profile data.
	 */
	public function actionProfile() {
		$model = $this->user;

		if ( isset($_POST[get_class($model)]) || isset($_POST[get_class($model->profile)])) {
			$model->attributes = $_POST[get_class($model)];
			$model->profile->attributes = $_POST[get_class($model->profile)];
			if ($model->validate()) {
				$model->save(false);
				Yii::app()->user->setFlash( 'account_profile' ,'Your profile data has been updated.');
				$this->refresh();
			}
		}

		$this->render('profile',array('model'=>$model));
	}
}