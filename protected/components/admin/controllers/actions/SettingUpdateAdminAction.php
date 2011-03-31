<?php
/**
 * SettingUpdateAdminAction class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.components.admin.controllers.actions.UpdateAdminAction');
 
/**
 * Admin panel action, which updates a batch of settings, stored in the database table with pair "name, value".
 * If update is successful, the page will be refreshed with the flash message.
 * The view file for this action is supposed containing {@link CActiveForm} widget with the cycle.
 */
class SettingUpdateAdminAction extends UpdateAdminAction {
    protected $_view = 'batch_update';
    
    /**
     * Runs the action.
     */
    public function run() {
        $controller = $this->getController();
        
        $modelClassName = $controller->getModelClassName();        
        
        $modelFinder = call_user_func( array($modelClassName,'model') );        
        $models = $modelFinder->findAll();
        
        if(isset($_POST[$modelClassName])) {
            $valid=true;
            foreach($models as $i=>$model) {
                if(isset($_POST[$modelClassName][$i])) {
                    $model->attributes=$_POST[$modelClassName][$i];
                }
                $valid = $valid && $model->validate();
            }
            if ($valid) {
                foreach($models as $model) {
                    $model->save();
                }
                Yii::app()->user->setFlash('form_result','Settings have been updated.');
                $controller->refresh();
            }
            
        }
        $controller->render($this->getView(),array(
            'models'=>$models,
        ));
    }
}