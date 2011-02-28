<?php

class Page_metaController extends AdminListController {
    
    public function init() {
        $this -> setModelClassName('PageMeta');
        
        $this->breadcrumbs=array(
            'Page Metas'=>array('index')
        );
    }
}
