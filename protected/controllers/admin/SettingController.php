<?php

class SettingController extends AdminListController {
    
    public function init() {
        $this -> setModelClassName('Setting');
        
        $this->breadcrumbs=array(
            'Settings'=>array($this->getId().'/'),
        );
    }
    
    /**
     * Overlaps list of allowed actions.
     */
    public function actions() {
        $actions = parent::actions();
        $actions['admin'] = $actions['index'];
        $actions['index'] = 'application.components.admin.controllers.actions.SettingUpdateAdminAction';
        return $actions;
    }
}
