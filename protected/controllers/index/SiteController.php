<?php

class SiteController extends IndexController {
	/**
	 * @return array action filters
	 */
	public function filters() {
		$filters = parent::filters();
		$filters[] = array(
			'ext.qs.lib.web.controllers.filters.QsFilterRedirectNotGuest + login',
		);
		return $filters;
	}

	/**
	 * Declares class-based actions.
	 * @return array actions list.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the forgot password page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
				'testLimit' => 1
			),
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		$parentRules = parent::accessRules();

		$rules = array(
			array(
				'allow',
				'actions' => array('error'),
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
		);

		$rules = array_merge($rules, $parentRules);
		return $rules;
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
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
	 * Displays the login page
	 */
	public function actionLogin() {
		if (!empty($_GET['service'])) {
			// External Auth :
			/* @var $externalAuth QsAuthExternalServiceCollection */
			$serviceId = $_GET['service'];
			$externalAuth = Yii::app()->getComponent('externalAuth');
			$service = $externalAuth->getService($serviceId);
			$userIdentity = $service->createUserIdentity();
			if ($userIdentity->authenticate()) {
				$model = new LoginExternalService();
				$model->setUserIdentity($userIdentity);
				if ($model->login()) {
					$service->redirectSuccess();
				} else {
					$newUserModel = $model->createNewUserModel();
					if ($newUserModel->save()) {
						$model->loginUserModel($newUserModel);
						$service->redirectSuccess();
					} else {
						/* @var $session CHttpSession */
						$session = Yii::app()->getComponent('session');
						$session->add('signUpExternalAttributes', $newUserModel->getAttributes());
						$service->redirect($this->createUrl('signup/external'));
					}
				}
			} else {
				$service->redirectCancel();
			}
		} else {
			// Normal login form :
			$model = new LoginFormIndex();
			if (isset($_POST[get_class($model)])) {
				$model->attributes = $_POST[get_class($model)];
				if ($model->login()) {
					$this->redirect(Yii::app()->getComponent('user')->getReturnUrl(array('account/index')));
				}
			}
			$this->render('login', array('model'=>$model));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->getComponent('user')->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Resets the user's password.
	 */
	public function actionForgotpassword() {
		$model = new ForgotPasswordForm();
		if (isset($_POST['ForgotPasswordForm'])) {
			$model->attributes = $_POST['ForgotPasswordForm'];
			if ($model->resetPassword()) {
				Yii::app()->getComponent('user')->setFlash('forgotPassword', 'Your password has been resetted. Check your email inbox.');
				$this->refresh();
			}
		}
		$this->render('forgot_password', array('model' => $model));
	}
}