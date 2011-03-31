<?php
/**
 * InsertAdminAction class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.components.admin.controllers.actions.BaseAdminAction');
 
/**
 * Admin panel action, which creates a new model.
 * If creation is successful, the browser will be redirected to the 'view' page.
 * The view file for this action is supposed containing {@link CActiveForm} widget.
 */
class InsertAdminAction extends BaseAdminAction {
    protected $_view = 'create';
    protected $_ajaxValidationEnabled = false;
    
    public function setAjaxValidationEnabled($ajaxValidationEnabled) {
        $this->_ajaxValidationEnabled = $ajaxValidationEnabled;
        return true;
    }
    
    public function getAjaxValidationEnabled() {
        return $this->_ajaxValidationEnabled;
    }
    
    /**
     * Runs the action.
     */
    public function run() {
        $controller = $this->getController();
        
        $modelClassName = $controller->getModelClassName();
        $modelScenarioName = $controller->getModelScenarioName();
                        
        $model=new $modelClassName;        
        
        $this->performAjaxValidation($model);

        if(isset($_POST[$modelClassName])) {
            $model->attributes=$_POST[$modelClassName];
            if($model->save()) {
                $controller->redirect(array('view','id'=>$model->id));
            }
        }

        $controller->render($this->getView(),array(
            'model'=>$model,
        ));
    }
    
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     * Set up {@link ajaxValidationEnabled} to "true" to make this method be actually performed.
     */
    protected function performAjaxValidation($model) {
        if ( $this->getAjaxValidationEnabled() ) {
            if(isset($_POST['ajax']) && $_POST['ajax']==='model-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
    }
}