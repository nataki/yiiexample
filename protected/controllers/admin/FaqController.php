<?php

class FaqController extends AdminListController {
	public function init() {
        $this->setModelClassName('Faq');
        
        $this->breadcrumbs=array(
            'FAQ'=>array($this->getId().'/'),
        );
    }
    
    /**
     * Returns list of behaviors.
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['dataModelBehavior'] = array(
            'class'=>'ext.qs.controllers.QsControllerBehaviorAdminDataModelContext',
            'contexts'=>array(
                'category'=>array(
                    'class'=>'FaqCategory',
                    'foreignKeyName'=>'category_id',
                    'controllerId'=>'faq_category',
                ),
            ),
        );
        return $behaviors;        
    }
}
