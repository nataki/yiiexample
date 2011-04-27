<?php

class HelpController extends IndexController {
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
        $this->redirect( array('/') );
    }
    
    public function actionContact() {
        $model=new ContactForm;
        if(isset($_POST['ContactForm'])) {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate()) {                                
                /*$headers="From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);*/
                
                $data = array(
                    'form'=>$model->formatAttributes(),
                    'site_name'=>Yii::app()->params['site_name'],
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