<?php

class AdminListController extends AdminBaseController {    
    /**
     * Initializes the controller.
     */
    public function init() {        
        parent::init();
    }
    
    /**
     * Returns list of behaviors.
     */
    public function behaviors() {
        return array(
            'dataModelBehavior' => array(
                'class'=>'ext.qs.controllers.QsControllerBehaviorAdminDataModel'
            )
        );
    }
    
    /**
     * Returns list of allowed actions.
     */
    public function actions() {
        return array(
            'index'=>'ext.qs.controllers.actions.QsActionAdminList',
            'view'=>'ext.qs.controllers.actions.QsActionAdminView',
            'create'=>'ext.qs.controllers.actions.QsActionAdminInsert',
            'update'=>'ext.qs.controllers.actions.QsActionAdminUpdate',
            'delete'=>'ext.qs.controllers.actions.QsActionAdminDelete',
        );
    }        
}
