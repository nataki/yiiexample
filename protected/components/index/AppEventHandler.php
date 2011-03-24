<?php

class AppEventHandler {
    public static function onBeginRequest(CEvent $event) {
        
        $urlManager=Yii::app()->getUrlManager();
                
        $urlRules = array();
        $staticPages = StaticPage::model()->findAll();
        if (is_array($staticPages)) {        
            foreach((array)$staticPages as $staticPage) {
                $urlRules[$staticPage->action]= 'page/'.$staticPage->action;
            }
            $urlManager->addRules($urlRules);
        } else {
            $staticPages = array();
        }
        
        $additional_params = Setting::model()->getValues();
        $additional_params['staticPages'] = $staticPages;
        Yii::app()->params = CMap::mergeArray( Yii::app()->params, $additional_params );
        
        return true;
    }
    
    public static function onEndRequest(CEvent $event) {
        return true;
    }
}