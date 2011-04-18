<?php

class MemberController extends AdminListController {
    
    public function init() {                
        $this->setModelClassName('Member');
        
        $this->breadcrumbs=array(
            'Members'=>array($this->getId().'/'),
        );
    }
    
    public function actions() {
        $actions = parent::actions();
        $actions['create'] = 'ext.qs.controllers.actions.QsActionAdminInsertRole';
        $actions['update'] = 'ext.qs.controllers.actions.QsActionAdminUpdateRole';
        return $actions;
    }
}
