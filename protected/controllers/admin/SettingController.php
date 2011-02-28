<?php

class SettingController extends AdminBaseController {
    
    public function init() {
        $this->breadcrumbs=array(
            'Settings'=>array('index'),
            'Edit'
        );
    }
    
    public function actionIndex() {
        $items = Setting::model()->findAll();
        
        if(isset($_POST['Setting'])) {
            $valid=true;
            foreach($items as $i=>$item) {
                if(isset($_POST['Setting'][$i]))
                    $item->attributes=$_POST['Setting'][$i];
                $valid=$valid && $item->validate();
            }
            if ($valid) {
                foreach($items as $item) {
                    $item->save();
                }
                Yii::app()->user->setFlash('form_result','Site settings have been updated.');
                $this->refresh();
            }
            
        }
        $this->render('main_from',array('items'=>$items));
    }
    
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
