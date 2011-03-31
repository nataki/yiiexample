<?php
/**
 * ViewAdminAction class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.components.admin.controllers.actions.BaseAdminAction');
 
/**
 * Admin panel action, which displays a particular model.
 * The view file for this action is supposed containing {@link CDetailView} widget.
 */
class ViewAdminAction extends BaseAdminAction {
    protected $_view = 'view';    
    
    /**
     * Runs the action.
     */
    public function run() {        
        $controller = $this->getController();
        $id = $_GET['id'];
        $model = $controller->loadModel($id);
        $controller->render($this->getView(),array(
            'model'=>$model,
        ));
    }
}