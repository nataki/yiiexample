<?php

class SiteController extends IndexController {
	/**
     * @return array action filters
     */
    public function filters() {
        $filters = parent::filters();
        $filters[] = array(
            'ext.qs.web.controllers.filters.QsFilterRedirectNotGuest + login',
        );        
        return $filters;        
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
                'backColor'=>0xFFFFFF,
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
	 * Displays the login page
	 */
	public function actionLogin() {
		$model = new LoginFormIndex();

		// collect user input data
		if(isset($_POST[get_class($model)])) {
			$model->attributes = $_POST[get_class($model)];
			// validate user input and redirect to the previous page if valid
			if($model->login()) {
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

    /**
	 * Resets the user's password.
	 */
    public function actionForgotpassword() {
        $model = new ForgotPasswordForm();
        if(isset($_POST['ForgotPasswordForm'])) {
            $model->attributes = $_POST['ForgotPasswordForm'];
            if ($model->resetPassword()) {
                Yii::app()->user->setFlash('forgotPassword','Your password has been resetted. Check your email inbox.');
                $this->refresh();
            }
        }
        $this->render('forgot_password',array('model'=>$model));
    }
}