<?php

class SiteController extends AdminBaseController {	
    
	public function actionIndex() {
        $this->render('index');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$this->layout='//layouts/single';
        $model = new LoginForm();

		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->login()) {
				$this->redirect(Yii::app()->user->returnUrl);
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