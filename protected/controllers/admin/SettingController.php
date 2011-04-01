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
        $actions['index'] = 'ext.qs.controllers.actions.QsActionAdminUpdateSetting';
        return $actions;
    }
}
