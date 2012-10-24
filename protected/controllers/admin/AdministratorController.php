<?php

class AdministratorController extends AdminListController {

	public function init() {
		$this->setModelClassName('Administrator');

		$this->breadcrumbs=array(
			'Administrators'=>array($this->getId().'/'),
		);
	}

	public function actions() {
		$actions = parent::actions();
		$actions['resetpassword'] = array(
			'class' => 'ext.qs.lib.web.controllers.actions.QsActionAdminCallModelMethod',
			'modelMethodName' => 'resetPassword',
			'flashMessage'=>'Password has been resetted successfully.'
		);
		return $actions;
	}
}
