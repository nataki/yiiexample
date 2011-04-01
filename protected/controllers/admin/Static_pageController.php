<?php

class Static_pageController extends AdminListController {
    
    public function init() {
        $this -> setModelClassName('StaticPage');
        
        $this->breadcrumbs=array(
            'Static Pages'=>array($this->getId().'/'),
        );
    }
    
    public function actions() {
        $actions = parent::actions();
        $actions['move'] = 'ext.qs.controllers.actions.QsActionAdminMove';
        return $actions;
    }
}
