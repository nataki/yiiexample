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
                'ext.qs.web.controllers.filters.QsFilterSecureConnection',
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
            $this->applyDefaultMetaData();
        }
        return true;
    }
    
    /**     
     * Registers all default page head data: title, css, js etc.     
     * @return boolean success
     */
    protected function applyDefaultMetaData() {
        $defaultDescription = Yii::app()->params['site_default_meta_description'];
        if (!empty($defaultDescription)) {
            Yii::app()->clientScript->registerMetaTag($defaultDescription,'description');
        }
        $defaultKeywords = Yii::app()->params['site_default_meta_keywords'];
        if (!empty($defaultKeywords)) {
            Yii::app()->clientScript->registerMetaTag($defaultKeywords,'keywords');
        }
        return true;
    }
}