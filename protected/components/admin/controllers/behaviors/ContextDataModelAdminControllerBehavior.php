<?php
/**
 * ContextDataModelAdminControllerBehavior class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.components.admin.controllers.behaviors.DataModelAdminControllerBehavior');
 
/**
 * Behavior for admin panel controller, which extends {@link DataModelAdminControllerBehavior}.
 * This behavior allows management in some filtering context. 
 * For example: items per specific category, comments by particular user etc.
 * This behavior finds and creates models including possible filtering context.
 */
class ContextDataModelAdminControllerBehavior extends DataModelAdminControllerBehavior {
    protected $_contexts = array();
    protected $_activeContexts = array();
    protected $_initialized = false;
    
    // Set / Get:
    public function setInitialized($initialized) {
        $this->_initialized = $initialized;
        return true;
    }
    
    public function getInitialized() {
        return $this->_initialized;
    }    
    
    // Contexts:
    public function setContexts(array $contexts) {
        $this->_contexts = array();
        foreach($contexts as $contextName => $contextConfig) {
            $this->addContext($contextName, $contextConfig);
        }
        return true;
    }
    
    public function getContexts() {
        return $this->_contexts;
    }
    
    public function addContext($name, array $config) {
        if (!array_key_exists('class', $config)) {
            throw new CException( '"'.get_class($this).'::'.__FUNCTION__.'" fails: parameter "class" has not been specified!' );
        }
        if (!array_key_exists('foreignKeyName', $config)) {
            $config['foreignKeyName'] = strtolower($config['class']).'_id';
        }
        if (!array_key_exists('controllerId', $config)) {
            $config['controllerId'] = strtolower($config['class']);
        }
        
        $this->_contexts[$name] = $config;
        return true;
    }
    
    public function getContext($name=null) {
        if ($name===null) {
            reset($this->_contexts);
            return current($this->_contexts);
        } else {
            return $this->_contexts[$name];
        }                
    }
    
    // Active contexts:
    public function setActiveContexts(array $activeContexts) {
        $this->_activeContexts = $activeContexts;
        return true;
    }
    
    public function getActiveContexts() {
        $this->initOnce();
        return $this->_activeContexts;
    }
    
    public function addActiveContext($name, array $config) {
        $this->_activeContexts[$name] = $config;
        return true;
    }
    
    public function getActiveContext($name=null) {
        $this->initOnce();
        if ($name===null) {
            reset($this->_activeContexts);
            return current($this->_activeContexts);
        } else {
            return $this->_activeContexts[$name];
        }
    }
    
    /**
     * Inits all active contexts.
     */
    protected function initActiveContexts() {
        foreach($this->_contexts as $contextName => $contextConfig) {
            $foreignKeyName = $contextConfig['foreignKeyName'];
            if (array_key_exists($foreignKeyName, $_GET)) {
                $this->initActiveContext($contextName, $contextConfig, $_GET[$foreignKeyName]);
            }
        }
        return true;
    }
    
    /**
     * Inits a particular active context.
     */
    protected function initActiveContext($contextName, array $contextConfig, $primaryKey) {
        $className = $contextConfig['class'];
        $modelFinder = call_user_func( array($className, 'model') );
        $model = $modelFinder->findByPk($primaryKey);
        if (empty($model)) {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        $contextConfig['model'] = $model;
        return $this->addActiveContext($contextName, $contextConfig);
    }
    
    /**
     * Inits all internal data once.
     */
    protected function initOnce() {
        if ( !$this->getInitialized() ) {
            $this->initActiveContexts();
            $this->setInitialized(true);
        }
        return true;
    }        
    
    /**
     * Returns model's foreign key attribute values for the active contexts.
     */
    public function getActiveContextModelAttributes() {
        $result = array();
        $activeContexts = $this->getActiveContexts();
        foreach($activeContexts as $activeContext) {
            $result[$activeContext['foreignKeyName']] = $activeContext['model']->getPrimaryKey();
        }
        return $result;
    }
    
    /**
     * Returns the data model based on the primary key.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = parent::loadModel($id);
        $activeContexts = $this->getActiveContexts();
        foreach($activeContexts as $activeContext) {
            $foreignKeyName = $activeContext['foreignKeyName'];
            if ($model->$foreignKeyName != $activeContext['model']->getPrimaryKey()) {
                throw new CHttpException(404,'The requested page does not exist.');
            }
        }
        
        return $model;
    }
    
    /**
     * Returns the new data model, with default values.
     * Such model should be used for the insert scenario.
     * Context foreign keys will be set to this model.
     */
    public function newModel() {
        $model = parent::newModel();
        $activeContexts = $this->getActiveContexts();
        foreach($activeContexts as $activeContext) {
            $foreignKeyName = $activeContext['foreignKeyName'];
            $model->$foreignKeyName = $activeContext['model']->getPrimaryKey();            
        }
        return $model;
    }
    
    /**
     * Returns the new data model, with default values are cleared.
     * Such model should be used for the list scenario: filter + list of records.
     * Context foreign keys will be set to this model.
     */
    public function newSearchModel() {
        $model = parent::newSearchModel();
        $activeContexts = $this->getActiveContexts();
        foreach($activeContexts as $activeContext) {
            $foreignKeyName = $activeContext['foreignKeyName'];
            $model->$foreignKeyName = $activeContext['model']->getPrimaryKey();            
        }
        return $model;
    }
}
