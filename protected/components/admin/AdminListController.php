<?php

/**
 * The base class for the controllers of administration panel, which provide CRUD operations.
 * Extend this controller if you need to create common administration panel section.
 *
 * @method boolean setModelClassName(string $modelClassName)
 *
 * @see QsControllerBehaviorAdminDataModel
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
				'class' => 'ext.qs.lib.web.controllers.QsControllerBehaviorAdminDataModel'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters() {
		$filters = parent::filters();
		$filters['postOnly'] = 'postOnly + delete';
		return $filters;
	}

	/**
	 * Returns list of allowed actions.
	 * @return array actions configuration.
	 */
	public function actions() {
		return array(
			'index' => 'ext.qs.lib.web.controllers.actions.QsActionAdminList',
			'view' => 'ext.qs.lib.web.controllers.actions.QsActionAdminView',
			'create' => 'ext.qs.lib.web.controllers.actions.QsActionAdminInsert',
			'update' => 'ext.qs.lib.web.controllers.actions.QsActionAdminUpdate',
			'delete' => 'ext.qs.lib.web.controllers.actions.QsActionAdminDelete',
		);
	}
}
