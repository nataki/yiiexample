<?php

class AdminListController extends AdminBaseController {
    protected $_modelClassName = '';
    protected $_modelScenarioName = 'search';
    
    // Set / Get :
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
    
    // Main:
    public function init() {        
        parent::init();
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
     * Returns list of allowed actions.
     */
    public function actions() {
        return array(
            'index'=>'application.components.admin.controllers.actions.ListAdminAction',
            'view'=>'application.components.admin.controllers.actions.ViewAdminAction',
            'create'=>'application.components.admin.controllers.actions.InsertAdminAction',
            'update'=>'application.components.admin.controllers.actions.UpdateAdminAction',
            'delete'=>'application.components.admin.controllers.actions.DeleteAdminAction',
        );
    }
        
}
