<?php

class PageController extends IndexController {
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		$this->missingAction('index');
	}

	/**
	 * Display the static pages.
	 */
	public function actionView($model) {
		if (is_object($model)) {
			return $this->render('static_page',array('model'=>$model));
		}
		return $this->missingAction($id);
	}
}