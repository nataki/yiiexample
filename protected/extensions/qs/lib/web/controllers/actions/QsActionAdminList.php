<?php
/**
 * QsActionAdminList class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2012 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

Yii::import('ext.qs.lib.web.controllers.actions.QsActionAdminBase');
 
/**
 * Admin panel action, which is using for management of all models.
 * The view file for this action is supposed containing {@link CGridView} widget.
 * Note: this action requires controller to provide method "newSearchModel()",
 * which should return the filter model for the listing.
 * You can use {@link QsControllerBehaviorAdminDataModel} behavior with this action.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.web.controllers.actions
 */
class QsActionAdminList extends QsActionAdminBase {
	/**
	 * @var string name of view which will be rendered during action.
	 */
	protected $_view = 'index';

	/**
	 * Runs the action.
	 */
	public function run() {
		$controller = $this->getController();

		$model = $controller->newSearchModel();
		$modelClassName = get_class($model);
		if (isset($_GET[$modelClassName])) {
			$model->attributes = $_GET[$modelClassName];
		}

		$viewData = array(
			'model' => $model,
		);
		if ( Yii::app()->getRequest()->getIsAjaxRequest() ) {
			$controller->renderPartial($this->getView(),$viewData);
		} else {
			$controller->render($this->getView(),$viewData);
		}
	}
}