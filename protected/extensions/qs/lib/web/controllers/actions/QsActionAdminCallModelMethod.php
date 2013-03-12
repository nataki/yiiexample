<?php
/**
 * QsActionAdminCallModelMethod class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2013 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

Yii::import('ext.qs.lib.web.controllers.actions.QsActionAdminInternalDbTransaction');

/**
 * Admin panel action, which calls the specified method for the model.
 * If {@link view} is set, it will be rendered,
 * otherwise redirect to the "view" action will be performed.
 * Use {@link flashMessage} to setup the user flash message, which should be
 * displayed if action is successful.
 *
 * @property string $modelMethodName public alias of {@link _modelMethodName}.
 * @property array $modelMethodParams public alias of {@link _modelMethodParams}.
 * @property string $flashMessageKey public alias of {@link _flashMessageKey}.
 * @property string $flashMessage public alias of {@link _flashMessage}.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.web.controllers.actions
 */
class QsActionAdminCallModelMethod extends QsActionAdminInternalDbTransaction {
	/**
	 * @var string name of view which will be rendered during action.
	 */
	protected $_view = '';
	/**
	 * @var string name of the model method, which should be called during the action.
	 */
	protected $_modelMethodName = '';
	/**
	 * @var array list of call parameters for the {@link modelMethodName} callback.
	 */
	protected $_modelMethodParams = array();
	/**
	 * @var string name of the user flash message, which should display the action success result.
	 */
	protected $_flashMessageKey = 'result';
	/**
	 * @var string content of the user flash message, which should be displayed if action is successful.
	 */
	protected $_flashMessage = '';

	// Set / Get :

	public function setModelMethodName($modelMethodName) {
		if (!is_string($modelMethodName)) {
			throw new CException('"'.get_class($this).'::modelMethodName" should be a string!');
		}
		$this->_modelMethodName = $modelMethodName;
		return true;
	}

	public function getModelMethodName() {
		return $this->_modelMethodName;
	}

	public function setModelMethodParams(array $modelMethodParams) {
		$this->_modelMethodParams = $modelMethodParams;
		return true;
	}

	public function getModelMethodParams() {
		return $this->_modelMethodParams;
	}

	public function setFlashMessageKey($flashMessageKey) {
		if (!is_string($flashMessageKey)) {
			throw new CException('"'.get_class($this).'::flashMessageKey" should be a string!');
		}
		$this->_flashMessageKey = $flashMessageKey;
		return true;
	}

	public function getFlashMessageKey() {
		return $this->_flashMessageKey;
	}

	public function setFlashMessage($flashMessage) {
		if (!is_string($flashMessage)) {
			throw new CException('"'.get_class($this).'::$flashMessage" should be a string!');
		}
		$this->_flashMessage = $flashMessage;
		return true;
	}

	public function getFlashMessage() {
		return $this->_flashMessage;
	}

	/**
	 * Runs the action.
	 * @param mixed $id - model primary key
	 */
	public function run($id=null) {
		$controller = $this->getController();

		$model = $controller->loadModel($id);

		$methodName = $this->getModelMethodName();
		if (empty($methodName)) {
			throw new CException('"'.get_class($this).'::modelMethodName" is empty!');
		}

		try {
			$this->beginInternalDbTransaction();
			call_user_func_array(array($model, $methodName), array());
			$this->commitInternalDbTransaction();
		} catch (Exception $exception) {
			$this->rollbackInternalDbTransaction();
			throw $exception;
		}

		$this->renderResult($model);
	}

	/**
	 * Renders the result of the view.
	 * If {@link view} is set, it will be rendered,
	 * otherwise redirect to the "view" action will be performed.
	 * @param CModel $model model instance.
	 */
	protected function renderResult(CModel $model) {
		$controller = $this->getController();

		$this->flashResult();

		$view = $this->getView();
		if (empty($view)) {
			$getParameters = $_GET;
			$controller->redirect(array_merge(array('view', 'id'=>$model->id), $getParameters));
		} else {
			$controller->render($view, array(
				'model' => $model,
			));
		}
	}

	/**
	 * Sets the user flash message with key {@link flashMessageKey} and
	 * content {@link flashMessage}.
	 * If any of the message parameters is empty no message will be set.
	 * @return boolean success.
	 */
	protected function flashResult() {
		$flashMessageKey = $this->getFlashMessageKey();
		$flashMessageContent = $this->getFlashMessage();

		if (!empty($flashMessageKey) && !empty($flashMessageContent)) {
			Yii::app()->getComponent('user')->setFlash($flashMessageKey, $flashMessageContent);
		}
		return true;
	}
}
