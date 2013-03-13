<?php

class SitesettingController extends AdminListController {
	public function init() {
		$this -> setModelClassName('SiteSetting');

		$this->breadcrumbs = array(
			'Site Settings' => array($this->getId().'/'),
		);
	}

	/**
	 * Overlaps list of allowed actions.
	 * @return array actions configuration.
	 */
	public function actions() {
		$actions = parent::actions();
		$actions['admin'] = $actions['index'];
		$actions['index'] = 'ext.qs.lib.web.controllers.actions.QsActionAdminUpdateSetting';
		$actions['move'] = 'ext.qs.lib.web.controllers.actions.QsActionAdminMove';
		return $actions;
	}
}
