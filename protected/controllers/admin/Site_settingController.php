<?php

class Site_settingController extends AdminListController {
    
    public function init() {
        $this -> setModelClassName('SiteSetting');
        
        $this->breadcrumbs=array(
            'Site Settings'=>array($this->getId().'/'),
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
