<?php
/**
 * DataModelAdminControllerBehavior class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

/**
 * Behavior for admin panel controller, which allows to create and find data models.
 * This behavior contains model class name and search scenario name.
 */
class DataModelAdminControllerBehavior extends CBehavior {
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
    
    /**
     * Returns the data model based on the primary key.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $modelClassName = $this->getModelClassName();
        $modelFinder = call_user_func( array($modelClassName, 'model') );
        $model = $modelFinder->findByPk((int)$id);
        if($model===null) {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }
    
    /**
     * Returns the new data model, with default values.
     * Such model should be used for the insert scenario.
     */
    public function newModel() {
        $modelClassName = $this->getModelClassName();
        $model = new $modelClassName();
        return $model;        
    }
    
    /**
     * Returns the new data model, with default values are cleared.
     * Such model should be used for the list scenario: filter + list of records.
     */
    public function newSearchModel() {
        $modelClassName = $this->getModelClassName();
        $modelScenarioName = $this->getModelScenarioName();
        
        $model = new $modelClassName($modelScenarioName);
        $model->unsetAttributes();  // clear any default values
        
        if ($_GET['status_id']) {
            $model->status_id = $_GET['status_id'];
        }
        
        return $model;
    }
}
