<?php

class FaqController extends AdminListController {
	public function init() {
        $this->setModelClassName('Faq');
        
        $this->breadcrumbs=array(
            'FAQ'=>array($this->getId().'/'),
        );
    }
}
