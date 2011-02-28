<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class IndexController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
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
     * This is the action to handle external exceptions.
     */
    
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
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/screen.css', 'screen, projection');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/print.css', 'print');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/main.css');
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/index/form.css');
        
        // JavaScripts:
        //Yii::app()->clientScript->registerScriptFile($baseUrl.'');
                
        $pageMeta = PageMeta::model()->current()->find();
        if (!empty($pageMeta)) {        
            //$this->pageTitle = $pageMeta->title;
            Yii::app()->name = $pageMeta->title;
            
            Yii::app()->clientScript->registerMetaTag($pageMeta->description, 'description');
            Yii::app()->clientScript->registerMetaTag($pageMeta->keywords, 'keywords');
        }
        return true;
    }
}