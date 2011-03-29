<?php
/**
 * UpdateAdminAction class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.controllers.admin.actions.InsertAdminAction');
 
/**
 * Admin panel action, which updates a particular model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * The view file for this action is supposed containing {@link CActiveForm} widget.
 */
class UpdateAdminAction extends InsertAdminAction {
    protected $_view = 'update';
    
    /**
     * Runs the action.
     */
    public function run() {
        $controller = $this->getController();
        
        $modelClassName = $controller->getModelClassName();        
        
        $id = $_GET['id'];
        $model = $controller->loadModel($id);
        
        $this->performAjaxValidation($model);

        if(isset($_POST[$modelClassName])) {
            $model->attributes=$_POST[$modelClassName];
            if($model->save()) 
                $controller->redirect(array('view','id'=>$model->id));
        }        

        $controller->render($this->getView(),array(
            'model'=>$model,
        ));
    }
}