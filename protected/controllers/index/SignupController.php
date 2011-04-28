<?php

class SignupController extends IndexController {
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
        );
    }
    
    public function actionIndex() {
        $model = new Member();
        
        if ( isset($_POST['Member']) || isset($_POST['MemberProfile']) ) {
            $model->attributes = $_POST['Member'];
            $model->profile->attributes = $_POST['MemberProfile'];
            if ($model->validate()) {
                $model->status_id = User::STATUS_ACTIVE;
                $model->save(false);
                
                // Send email confirmation:
                $data = array(
                    'member'=>$model
                );
                $emailMessage = Yii::app()->email->createEmailByPattern('signup', $data);
                $emailMessage->setTo($model->email);
                $emailMessage->send();
                
                // Log in new user:
                $loginForm = new LoginForm();
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