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