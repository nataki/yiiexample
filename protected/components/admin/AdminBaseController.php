<?php

//Yii::import('application.models.admin.*');

class AdminBaseController extends CController {
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/column2';
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
            'accessControl', // perform access control for CRUD operations
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
         
    public function actionError() {
        if($error=Yii::app()->errorHandler->error) {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    protected function beforeRender($view) {
        // Meta Tags:
        Yii::app()->clientScript->registerMetaTag('text/html; charset=utf-8', null, 'Content-Type');
        Yii::app()->clientScript->registerMetaTag('en', 'language');        
                
        $baseUrl = Yii::app()->request->baseUrl;
        // Css:
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/screen.css', 'screen, projection');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/print.css', 'print');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/main.css');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/admin/form.css');
        
        // Java Scripts:
        //Yii::app()->clientScript->registerScriptFile($baseUrl.'');
                        
        return true;
    }
}