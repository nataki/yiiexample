<?php

/**
 * The base class for the controllers of administration panel.
 * This class stores most common fields, which are used during the page rendering.
 * This class sets up access control filter, which restrict access to the administration panel. 
 */
class AdminBaseController extends CController {
    /**
     * @var string the default layout for the controller view.
     */
    public $layout='//layouts/main';
    /**
     * @var array main menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $mainMenuItems=array();
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $contextMenuItems=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();
    /**
     * @var string contains the title of the current section. 
     * It should change depending on the particular action.
     */
    public $sectionTitle='Administration Area';
     
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl' => 'accessControl', // perform access control
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('error'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'actions' => array('login'),
                'users' => array('?'),
            ),
            array(
                'allow',
                'actions' => array('logout'),
                'users' => array('@'),
            ),
            array(
                'allow',                
                'roles'=>array('admin')
            ),
            array('deny',  // deny all users                
                'users'=>array('*'),                
            ),
        );
    }
         
    /**
     * This is the action to handle external exceptions.
     * For {@link CHttpException}, if view "errorXXX" with its code exists,
     * this view will be rendered, if not view "error" will be used.
     */
    public function actionError() {
        if($error=Yii::app()->errorHandler->error) {
            if(Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                if ($error['type']=='CHttpException') {
                    $viewName = '//errors/error'.$error['code'];
                    if ($this->getViewFile($viewName)) {
                        return $this->render($viewName, $error);
                    }
                }
                $this->render('//errors/error', $error);
            }
        }
    }
    
    /**
     * This method is invoked at the beginning of {@link render()}.
     * It registers all default page head data: title, css, js etc.
     * @param string $view the view to be rendered
     * @return boolean whether the view should be rendered.     
     */
    protected function beforeRender($view) {
        if (!Yii::app()->request->getIsAjaxRequest()) {
            $this->composePageHead();
        }
        return true;
    }
    
    protected function composePageHead() {
        // Determine IE version:
        if ( preg_match('/MSIE ([0-9]\.[0-9])/',$_SERVER['HTTP_USER_AGENT'],$matches) ) {
            $ieVersion = $matches[1];
        } else {
            $ieVersion = null;
        }
        
        // Meta Tags:
        Yii::app()->clientScript->registerMetaTag('text/html; charset=utf-8', null, 'Content-Type');
        Yii::app()->clientScript->registerMetaTag('en', 'language');        
                
        $baseUrl = Yii::app()->request->baseUrl;
        // Css:
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/screen.css', 'screen, projection');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/print.css', 'print');
        if( $ieVersion && version_compare($ieVersion, '7', '<') ) {
            Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/ie.css');
        }
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/main.css');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/form.css');                
        
        // Java Scripts:
        //Yii::app()->clientScript->registerScriptFile($baseUrl.'');
    }
}