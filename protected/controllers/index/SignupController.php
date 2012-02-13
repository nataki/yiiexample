<?php

class SignupController extends IndexController {
    /**
     * @return array action filters
     */
    public function filters() {
        $filters = parent::filters();
        $filters[] = array(
            'ext.qs.controllers.filters.QsFilterRedirectNotGuest',
        );        
        return $filters;        
    }
    
    /**
     * Declares class-based actions.
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
     * Main action.
     */
    public function actionIndex() {
        $model = new SignupForm();
        
        if ( isset($_POST['SignupForm']) ) {
            $model->attributes = $_POST['SignupForm'];            
            if ($model->validate()) {                
                $model->save(false);
                
                // Log in new user:
                $loginForm = new LoginFormIndex();
                $loginForm->username = $model->name;
                $loginForm->password = $model->new_password;
                if (!$loginForm->login()) {
                    throw new CException('Unable to log in new user!');
                }
                
                $this->redirect( array('account/') );
            }
        }
        
        $this->render('signup_form', array('model'=>$model));
    }
}