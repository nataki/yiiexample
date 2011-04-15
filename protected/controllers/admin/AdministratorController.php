<?php

class AdministratorController extends AdminListController {
    
    public function init() {                
        $this->setModelClassName('Administrator');
        
        $this->breadcrumbs=array(
            'Administrators'=>array($this->getId().'/'),
        );
    }
}
