<?php

class UserController extends AdminListController {
    
    public function init() {                
        $this->setModelClassName('User');
        
        $this->breadcrumbs=array(
            'Users'=>array($this->getId().'/'),
        );
    }
}
