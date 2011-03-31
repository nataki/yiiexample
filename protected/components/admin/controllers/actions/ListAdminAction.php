<?php
/**
 * ListAdminAction class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.components.admin.controllers.actions.BaseAdminAction');
 
/**
 * Admin panel action, which is using for management of all models.
 * The view file for this action is supposed containing {@link CGridView} widget.
 */
class ListAdminAction extends BaseAdminAction {
    protected $_view = 'index';
    
    /**
     * Runs the action.
     */
    public function run() {
        $controller = $this->getController();
        
        $modelClassName = $controller->getModelClassName();        
        
        $model = $controller->newSearchModel();
        if(isset($_GET[$modelClassName])) {
            $model->attributes=$_GET[$modelClassName];
        }

        $controller->render($this->getView(),array(
            'model'=>$model,
        ));
    }
}