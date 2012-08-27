<?php

class SiteController extends AdminBaseController {	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		$accessRules = array_merge(
			array(
				array(
					'allow',
					'actions' => array('error','captcha'),
					'users' => array('*'),
				),
				array(
					'allow',
					'actions' => array('login'),
					'users' => array('?'),
				),
				array(
					'allow',
					'actions' => array('logout'),
					'users' => array('@'),
				),
			),
			parent::accessRules()
		);
		return $accessRules;
	}

	/**
	 * Declares class-based actions.
	 * @return array actions list.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'foreColor'=>0x444444,
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * Displays the administration dashboard.
	 */
	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 * For {@link CHttpException}, if view "errorXXX" with its code exists,
	 * this view will be rendered, if not view "error" will be used.
	 */
	public function actionError() {
		if ($error=Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				$errorViewName = '//errors/error';
				if ($error['type']=='CHttpException') {
					$httpErrorViewName = '//errors/error'.$error['code'];
					if ($this->getViewFile($httpErrorViewName)) {
						$errorViewName = $httpErrorViewName;
					}
				}
				$this->render($errorViewName, $error);
			}
		}
	}

	/**
	 * Displays the login page.
	 */
	public function actionLogin() {
		$this->layout = '//layouts/single';
		$model = new LoginFormAdmin();

		// collect user input data
		if (isset($_POST[get_class($model)])) {
			$model->attributes = $_POST[get_class($model)];
			// validate user input and redirect to the previous page if valid
			if ($model->login()) {
				$this->redirect( Yii::app()->user->getReturnUrl( array('site/index') ) );
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}