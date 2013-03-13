<?php

class EmailpatternController extends AdminListController {
	public function init() {
		$this->setModelClassName('EmailPattern');

		$this->breadcrumbs = array(
			'Email Patterns' => array($this->getId().'/'),
		);
	}
}
