<?php

/**
 * The base class for the controllers of administration panel, which provide CRUD operations.
 * Extend this controller if you need to create common administration panel section.
 */
class AdminListController extends AdminBaseController {
	/**
	 * Initializes the controller.
	 */
	public function init() {
		parent::init();
	}

	/**
	 * Returns list of behaviors.
	 * @return array behaviors configuration.
	 */
	public function behaviors() {
		return array(
			'dataModelBehavior' => array(
				'class'=>'ext.qs.web.controllers.QsControllerBehaviorAdminDataModel'
			)
		);
	}

	/**
	 * Returns list of allowed actions.
	 * @return array actions configuration.
	 */
	public function actions() {
		return array(
			'index'=>'ext.qs.web.controllers.actions.QsActionAdminList',
			'view'=>'ext.qs.web.controllers.actions.QsActionAdminView',
			'create'=>'ext.qs.web.controllers.actions.QsActionAdminInsert',
			'update'=>'ext.qs.web.controllers.actions.QsActionAdminUpdate',
			'delete'=>'ext.qs.web.controllers.actions.QsActionAdminDelete',
		);
	}
}
