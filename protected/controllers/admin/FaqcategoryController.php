<?php

class FaqcategoryController extends AdminListController {
	public function init() {
		$this->setModelClassName('FaqCategory');

		$this->breadcrumbs=array(
			'FAQ Categories'=>array($this->getId().'/'),
		);
	}

	public function actions() {
		$actions = parent::actions();
		$actions['move'] = 'ext.qs.web.controllers.actions.QsActionAdminMove';
		return $actions;
	}
}
