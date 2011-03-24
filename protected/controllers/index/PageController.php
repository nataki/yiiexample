<?php

class PageController extends IndexController {
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        parent::missingAction('index');
    }
    
    /**
     * Display the static pages.
     */
    public function missingAction($actionId) {
        $attributes = array('action' => $actionId);
        $staticPage = StaticPage::model()->findByAttributes($attributes);
        if (is_object($staticPage)) {
            $action = new CViewAction($this, $actionId);
            $this->setAction($action);
            return $this->render('static_page',array('staticPage'=>$staticPage));
        }
        
        return parent::missingAction($actionId);
    }
}