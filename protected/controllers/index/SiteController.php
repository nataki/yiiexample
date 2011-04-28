<?php

class SiteController extends IndexController {
	/**
     * @return array action filters
     */
    public function filters() {
        $filters = parent::filters();
        $filters[] = array(
            'ext.qs.controllers.filters.QsFilterRedirectNotGuest + login',
        );        
        return $filters;        
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
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm'])) {
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
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