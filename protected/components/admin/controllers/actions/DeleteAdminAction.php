<?php
/**
 * DeleteAdminAction class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.components.admin.controllers.actions.BaseAdminAction');
 
/**
 * Admin panel action, which deletes a particular model.
 * If deletion is successful, the browser will be redirected to the 'index' page.
 */
class DeleteAdminAction extends BaseAdminAction {
    
    /**
     * Runs the action.
     */
    public function run() {        
        $controller = $this->getController();
        $id = $_GET['id'];
        
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $controller->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
}