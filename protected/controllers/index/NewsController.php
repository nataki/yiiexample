<?php

class NewsController extends IndexController {
    public function actionIndex() {
        $model = new News();
        $this->render('list', array('model'=>$model));
    }
    
    public function actionView($id) {
        $model=News::model()->findByPk((int)$id);                
        
        if (empty($model)) {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        $this->render('view', array('model'=>$model));
    }
}