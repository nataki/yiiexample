<?php

class AdminListController extends AdminBaseController {
    protected $_modelClassName = '';
    protected $_modelScenarioName = 'search';
    
    // Common:
    public function setModelClassName($modelClassName) {
        if (!is_string($modelClassName)) return false;
        $this->_modelClassName = $modelClassName;
        return true;
    }
    
    public function getModelClassName() {
        return $this->_modelClassName;
    }
    
    public function setModelScenarioName($modelScenarioName) {
        if (!is_string($modelScenarioName)) return false;
        $this->_modelScenarioName = $modelScenarioName;
        return true;
    }
    
    public function getModelScenarioName() {
        return $this->_modelScenarioName;
    }
    
    public function init() {
        ;
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $modelClassName = $this->_modelClassName;
        $rawModel = call_user_func( array($modelClassName, 'model') );
        $model=$rawModel->findByPk((int)$id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    /**
     * Manages all models.
     */
    public function actionIndex() {        
        $modelClassName = $this->_modelClassName;        
        $model=new $modelClassName($this->_modelScenarioName);
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET[$modelClassName]))
            $model->attributes=$_GET[$modelClassName];

        $this->render('index',array(
            'model'=>$model,
        ));
    }
    
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $modelClassName = $this->_modelClassName;
        $model=new $modelClassName;        

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST[$this->_modelClassName]))
        {
            $model->attributes=$_POST[$this->_modelClassName];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));            
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST[$this->_modelClassName]))
        {
            $model->attributes=$_POST[$this->_modelClassName];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }     

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if(isset($_POST['ajax']) && $_POST['ajax']==='model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
