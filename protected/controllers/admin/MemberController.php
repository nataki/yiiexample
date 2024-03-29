<?php

class MemberController extends AdminListController {
	public function init() {
		$this->setModelClassName('Member');

		$this->breadcrumbs = array(
			'Members' => array($this->getId().'/'),
		);
	}

	public function actions() {
		$actions = parent::actions();
		$actions['create'] = 'ext.qs.lib.web.controllers.actions.QsActionAdminInsertRole';
		$actions['update'] = 'ext.qs.lib.web.controllers.actions.QsActionAdminUpdateRole';
		$actions['resetpassword'] = array(
			'class' => 'ext.qs.lib.web.controllers.actions.QsActionAdminCallModelMethod',
			'modelMethodName' => 'resetPassword',
			'flashMessage' => 'Password has been resetted successfully.'
		);
		return $actions;
	}
}
