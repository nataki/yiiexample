<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class IndexController extends CController {
	/**
	 * @var string the default layout for the controller view.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'secureConnection' => array(
                'ext.qs.controllers.filters.QsFilterSecureConnection',
                'useSecureConnection'=>false
            ),
            'accessControl' => 'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('deny',  // deny from admin
                'roles'=>array('admin'),
            ),
        );
    }
    
    /**
     * Returns list of behaviors.
     */
    public function behaviors() {
        return array(
            'metaDataBehavior' => array(
                'class'=>'ext.qs.controllers.QsControllerBehaviorMetaDataComposer'
            )
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
                    $viewName = 'error'.$error['code'];
                    if ($this->getViewFile($viewName)) {
                        return $this->render($viewName, $error);
                    }
                }
                $this->render('error', $error);
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
    
    /**     
     * Registers all default page head data: title, css, js etc.     
     * @return boolean success
     */
    protected function composePageHead() {
        // Application name:
        $siteName = Yii::app()->params['site_name'];
        if (!empty($siteName)) {
            Yii::app()->name = $siteName;
        }
        
        // Default meta data:
        $this->applyDefaultMetaData();
        Yii::app()->clientScript->registerMetaTag('General', 'rating');
        
        // Determine IE version:
        if ( preg_match('/MSIE ([0-9]\.[0-9])/',$_SERVER['HTTP_USER_AGENT'],$matches) ) {
            $ieVersion = $matches[1];
        } else {
            $ieVersion = null;
        }
                
        $baseUrl = Yii::app()->request->baseUrl;
        
        // Css:
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/screen.css', 'screen, projection');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/print.css', 'print');
        if( $ieVersion && version_compare($ieVersion, '7', '<') ) {
            Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/ie.css');
        }
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/main.css');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/form.css');
        
        // JavaScripts:
        //Yii::app()->clientScript->registerScriptFile($baseUrl.'');                
        
        return true;
    }
}