<?php

class AuthlogController extends AdminListController {
	public function init() {
		$this->setModelClassName('AuthLog');

		$this->breadcrumbs = array(
			'Auth Logs' => array($this->getId().'/'),
		);
	}

	public function actions() {
		$actions = parent::actions();
		unset($actions['create']);
		unset($actions['update']);
		return $actions;
	}
}
