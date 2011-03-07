<?php

class SiteController extends AdminBaseController {	
    
	public function actionIndex() {		        
        /*echo('<pre>');
        print_r($_COOKIE);
        exit;*/
        
        // renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
        /*$auth = Yii::app()->authManager;
        
        $auth->assign('admin','admin','');*/
        
        /*$bizRule = 'return Yii::app()->user->group_id==1;';
        $auth -> createRole('member', 'site members', $bizRule);
        die('done');*/
        
        //print_r(Yii::app()->user->group_id);exit;
        
        /*$result = Yii::app()->authManager->getRoles();
        echo('<pre>');
        print_r($result);exit;*/
                
        $this->render('index');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$this->layout='//layouts/column1';
        $model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
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