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
	 * @param CModel $model static page model.
	 */
	public function actionView($model) {
		if (is_object($model)) {
			$this->render('static_page', array('model'=>$model));
		} else {
			$this->missingAction($model);
		}
	}
}