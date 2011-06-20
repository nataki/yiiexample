<?php

class HelpController extends IndexController {
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
    
    public function actionIndex() {
        $this->redirect( array('contact') );
    }
    
    public function actionContact() {
        $model=new ContactForm;
        if(isset($_POST['ContactForm'])) {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate()) {                                
                $data = array(
                    'form'=>$model,
                );
                $emailMessage = Yii::app()->email->createEmailByPattern('contact', $data);
                // Set all site administrators as receivers:
                $administrators = Administrator::model()->active()->findAll();
                foreach($administrators as $administrator) {
                    $emailMessage->addTo( $administrator->email );
                }
                $emailMessage->send();
                                            
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact',array('model'=>$model));
    }
    
    public function actionFaq() {        
        $this->render('faq');
    }
}