<?php

class AppEventHandler {
    public static function onBeginRequest(CEvent $event) {
        $urlManager=Yii::app()->getUrlManager();
                                        
        $staticPages = self::findStaticPageAll();
        if (is_array($staticPages)) {
            $urlRules = array();
            foreach((array)$staticPages as $staticPage) {
                $urlRules[$staticPage->action]= 'page/'.$staticPage->action;
            }
            $urlManager->addRules($urlRules);
        } else {
            $staticPages = array();
        }
        
        $additionalParams = SiteSetting::model()->getValues();
        $additionalParams['staticPages'] = $staticPages;
        Yii::app()->params = CMap::mergeArray( Yii::app()->params, $additionalParams );
        
        return true;
    }
    
    public static function onEndRequest(CEvent $event) {
        return true;
    }
    
    protected static function findStaticPageAll() {
        $staticPageFinder = StaticPage::model();
        $criteria = array(
            'order' => 'position ASC'
        );
        $staticPages = $staticPageFinder->cache(60)->findAll($criteria);
        return $staticPages;
    }
}