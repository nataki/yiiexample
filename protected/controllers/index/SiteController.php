<?php

class SiteController extends IndexController {
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		//CVarDumper::dump($this,99,true);exit;
        
        
        // renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
        /*$model = new Member();
        var_dump($model->profile);
        exit;
        
        
        $models = Member::model()->findAll();
        
        list($model) = $models;
        $model->profile->setAttribute('first_name', 'test first name');        
        //$model->profile->save();
        //$model->save();
        
        die('done');*/
        
        $this->render('index');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
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