<?php

class FaqController extends AdminListController {
	public function init() {
        $this->setModelClassName('Faq');
        
        $breadcrumbs = array();
        
        $activeContexts = $this->getActiveContexts();
        foreach($activeContexts as $activeContext) {
            $breadcrumbs[$activeContext['controllerTitle']] = array($activeContext['controllerId'].'/');
            $breadcrumbs[$activeContext['model']->id] = array($activeContext['controllerId'].'/view', 'id'=>$activeContext['model']->id);
        }
        
        $breadcrumbs['FAQ'] = array($this->getId().'/');
        $this->breadcrumbs = $breadcrumbs;        
    }
    
    public function actions() {
        $actions = parent::actions();
        $actions['move'] = 'ext.qs.controllers.actions.QsActionAdminMove';
        return $actions;
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
                    'controllerTitle'=>'FAQ category'
                ),
            ),
        );
        return $behaviors;        
    }
}
