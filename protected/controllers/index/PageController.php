<?php

class PageController extends IndexController {
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->missingAction('index');
    }
    
    /**
     * Display the static pages.
     */
    public function actionView($id) {
        $attributes = array('action' => $id);
        $staticPage = StaticPage::model()->findByAttributes($attributes);
        if (is_object($staticPage)) {
            return $this->render('static_page',array('staticPage'=>$staticPage));
        }
        return $this->missingAction($id);
    }
}