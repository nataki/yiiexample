<?php

class MemberController extends AdminListController {
    
    public function init() {                
        $this->setModelClassName('Member');
        
        $this->breadcrumbs=array(
            'Members'=>array($this->getId().'/'),
        );
    }
}
