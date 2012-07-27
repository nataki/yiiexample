<?php

class Email_patternController extends AdminListController {

	public function init() {
		$this -> setModelClassName('EmailPattern');

		$this->breadcrumbs=array(
			'Email Patterns'=>array($this->getId().'/'),
		);
	}
}
