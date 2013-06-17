<?php

class SignupController extends IndexController {
	/**
	 * @return array action filters
	 */
	public function filters() {
		$filters = parent::filters();
		$filters[] = array(
			'ext.qs.lib.web.controllers.filters.QsFilterRedirectNotGuest',
		);
		return $filters;
	}

	/**
	 * Declares class-based actions.
	 * @return array actions config.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the signup form
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
				'testLimit' => 1
			),
		);
	}

	/**
	 * Logs in new signed up user.
	 * @param SignupForm $model sign up model.
	 * @throws CException on failure.
	 */
	protected function login($model) {
		$loginForm = new LoginFormIndex();
		$loginForm->username = $model->name;
		$loginForm->password = $model->new_password;
		if (!$loginForm->login()) {
			throw new CException('Unable to log in new user!');
		}
		$this->redirect(array('account/'));
	}

	/**
	 * Performs sign up via data retrieved from the web form.
	 */
	public function actionIndex() {
		$model = new SignupForm();

		if (isset($_POST['SignupForm'])) {
			$model->attributes = $_POST['SignupForm'];
			if ($model->validate()) {
				$model->save(false);
				$this->login($model);
			}
		}

		$this->render('signup_default', array('model' => $model));
	}

	/**
	 * Performs sign up via external service.
	 * This action will be invoked in case data retrieved from external service
	 * during login is not enough to create new user account.
	 */
	public function actionExternal() {
		/* @var $session CHttpSession */
		$session = Yii::app()->getComponent('session');

		$externalAttributes = $session->get('signUpExternalAttributes');
		if (empty($externalAttributes)) {
			throw new CHttpException(400, 'Invalid request.');
		}

		$model = new SignupForm('external');
		$model->setAttributes($externalAttributes, false);

		if (isset($_POST['SignupForm'])) {
			$model->attributes = $_POST['SignupForm'];
			if ($model->validate()) {
				$model->save(false);
				$session->remove('signUpExternalAttributes');
				$this->login($model);
			}
		} else {
			$model->attributes = $externalAttributes;
		}
		$this->render('signup_external', array(
			'model' => $model,
			'externalAuthService' => $model->getExternalAuthService(),
		));
	}
}