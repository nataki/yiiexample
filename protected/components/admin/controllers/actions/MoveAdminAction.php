<?php
/**
 * MoveAdminAction class file.
 *
 * @author Paul Klimov <pklimov@quart-soft.com> 
 * @link http://www.quart-soft.com/
 * @copyright Copyright &copy; 2008-2011 QuartSoft ltd.
 * @license http://www.quart-soft.com/license/
 */

Yii::import('application.components.admin.controllers.actions.BaseAdminAction');
 
/**
 * Admin panel action, which moves models according to {@link QsActiveRecordBehaviorPosition}.
 * If movement is successful, the browser will be redirected to the 'index' page.
 */
class MoveAdminAction extends BaseAdminAction {    
    
    /**
     * Runs the action.
     */
    public function run() {        
        $controller = $this->getController();
        
        $id = $_GET['id'];
        $model = $controller->loadModel($id);
        
        
        $direction = $_GET['to'];
        
        switch($direction) {
            case 'first': {
                $model->moveFirst();
                break;
            }
            case 'prev': {
                $model->movePrev();
                break;
            }
            case 'next': {
                $model->moveNext();
                break;
            }
            case 'last': {
                $model->moveLast();
                break;
            }
            case 'up': {
                $model->movePrev();
                break;
            }
            case 'down': {
                $model->moveNext();
                break;
            }
            default: {
                if(is_numeric($direction)) {
                    $model->moveToPosition($direction);
                }
            }
        }
                
        $positionAttributeName = $model->getPositionAttributeName();
        $sortGetParameterName = get_class($model).'_sort';
        
        $controller->redirect(array('index', $sortGetParameterName=>$positionAttributeName));
    }
}