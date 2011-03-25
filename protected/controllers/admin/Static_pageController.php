<?php

class Static_pageController extends AdminListController {
    
    public function init() {
        $this -> setModelClassName('StaticPage');
        
        $this->breadcrumbs=array(
            'Static Pages'=>array('index')
        );
    }
}
