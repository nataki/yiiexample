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
	public $layout='//layouts/inner';
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
				'roles'=>array('admin')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
}