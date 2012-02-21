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
        $actions['index'] = 'ext.qs.web.controllers.actions.QsActionAdminUpdateSetting';
        $actions['move'] = 'ext.qs.web.controllers.actions.QsActionAdminMove';
        return $actions;
    }
}
