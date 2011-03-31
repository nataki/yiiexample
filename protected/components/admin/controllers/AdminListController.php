<?php

class AdminListController extends AdminBaseController {
    
    // Main:
    public function init() {        
        parent::init();
    }
    
    /**
     * Returns list of behaviors.
     */
    public function behaviors() {
        return array(
            'dataModel' => array(
                'class'=>'application.components.admin.controllers.behaviors.DataModelAdminControllerBehavior'
            )
        );
    }
    
    /**
     * Returns list of allowed actions.
     */
    public function actions() {
        return array(
            'index'=>'application.components.admin.controllers.actions.ListAdminAction',
            'view'=>'application.components.admin.controllers.actions.ViewAdminAction',
            'create'=>'application.components.admin.controllers.actions.InsertAdminAction',
            'update'=>'application.components.admin.controllers.actions.UpdateAdminAction',
            'delete'=>'application.components.admin.controllers.actions.DeleteAdminAction',
        );
    }
        
}
