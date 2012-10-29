<?php
/**
 * QsCrudAdminCode class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2012 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

Yii::import('gii.generators.crud.CrudCode');

/**
 * QsCrudAdminCode extension of {@link CrudCode}, which appends attributes allowing
 * saving generated files in custom destination.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.gii
 */
class QsCrudAdminCode extends CrudCode {
	public $baseControllerClass = 'AdminListController';
	public $viewPath = 'application.views.admin';
	public $controllerPath = 'application.controllers.admin';

	public function rules() {
		return array_merge(parent::rules(), array(
			array('viewPath, controllerPath', 'required'),
			array('viewPath, controllerPath', 'match', 'pattern'=>'/^\w+[\.\w+]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('viewPath, controllerPath', 'sticky'),
		));
	}

	public function getControllerFile() {
		$module=$this->getModule();
		$id=$this->getControllerID();
		if (($pos=strrpos($id,'/'))!==false) {
			$id[$pos+1]=strtoupper($id[$pos+1]);
		} else {
			$id[0]=strtoupper($id[0]);
		}
		return Yii::getPathOfAlias($this->controllerPath).'/'.$id.'Controller.php';
	}

	public function prepare() {
		$originalViewPath = $this->viewPath;
		$this->viewPath = Yii::getPathOfAlias($originalViewPath).'/'.$this->controller;
		parent::prepare();
		$this->viewPath = $originalViewPath;
	}
}