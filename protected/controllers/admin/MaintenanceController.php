<?php
 
class MaintenanceController extends AdminBaseController {
	public function init() {
		$this->breadcrumbs=array(
			'Maintenance'=>array($this->getId().'/'),
		);
	}

	protected function setResultMessage($message) {
		return Yii::app()->user->setFlash('maintenanceResult',$message);
	}

	protected function renderIndex($message=null) {
		$this->setResultMessage($message);
		$this->render('index');
	}

	public function actionIndex() {
		$this->render('index');
	}

	public function actionClearcache() {
		Yii::app()->cache->flush();
		$this->renderIndex('Cache has been cleared successfully.');
	}
}
