<?php
/**
 * QsLinkPager class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2012 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

/**
 * QsLinkPager widget is an extension on the standard Yii widget {@link CLinkPager},
 * which allows to render pager based on the specified view file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.web.widgets
 */
class QsLinkPager extends CLinkPager {
	protected $_view = 'application.views.index.pagers.pager';
	protected $_buttons = array();

	// Set / Get:
	public function setView($view) {
		if ( !is_string($view) && !empty($view)) return false;
		$this->_view = $view;
		return true;
	}

	public function getView() {
		return $this->_view;
	}

	public function setButtons(array $buttons) {
		$this->_buttons = $buttons;
		return true;
	}

	public function getButtons() {
		return $this->_buttons;
	}

	// Main:
	public function run() {
		if (empty($this->_view)) {
			parent::run();
		} else {
			$this->registerClientScript();
			$buttons=$this->createPageButtons();
			if (empty($buttons)) return;

			$this->setButtons($buttons);

			$renderData = array(
				'widget' => $this,
			);
			//$this->render($this->_view,$renderData);

			$owner = $this->getOwner();
			$renderMethod = $owner instanceof CController ? 'renderPartial' : 'render';
			return $owner->$renderMethod($this->_view, $renderData);

		}
	}

	protected function createPageButton($label,$page,$class,$hidden,$selected) {
		if (empty($this->_view)) {
			return parent::createPageButton($label,$page,$class,$hidden,$selected);
		} else {
			if ($hidden || $selected) {
				$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
			}

			$button = array(
				'label' => $label,
				'class' => $class,
				'url' => CHtml::normalizeUrl( $this->createPageUrl($page) ),
				'page' => $page,
				'hidden' => $hidden,
				'selected' => $selected,
			);
			return $button;
		}
	}
}