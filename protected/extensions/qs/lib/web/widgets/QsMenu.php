<?php
/**
 * QsMenu class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2013 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

Yii::import('zii.widgets.CMenu');

/**
 * QsMenu widget is an extension on the standard Yii widget {@link CMenu}.
 * it allows to render menu inline in view file, where the widget was created.
 * Use {@link CBaseController::beginWidget} and {@link CBaseController::endWidget}, after the widget has been created, 
 * its internal {@link items} are normalized and should be placed in the cycle operator:
 * <code>
 * foreach ($widget->items as $item) {
 *     ...
 * }
 * </code>
 * Set {@link autoRender} to "true" to make QsMenu behave exactly like CMenu.
 *
 * @property string $autoRender public alias of {@link _autoRender}.
 * @property string $itemActivityDirectMatching public alias of {@link _itemActivityDirectMatching}.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.web.widgets
 */
class QsMenu extends CMenu {
	/**
	 * @var boolean determines should the widget be rendered as {@link CMenu} or not.
	 */
	protected $_autoRender = false;
	/**
	 * @var boolean determines if the active item will be determine with direct link matching.
	 * If true activity matching will be performed as {@link CMenu} native implementation.
	 */
	protected $_itemActivityDirectMatching = false;

	// Set/Get:

	public function setAutoRender($autoRender) {
		$this->_autoRender = $autoRender;
		return true;
	}

	public function getAutoRender() {
		return $this->_autoRender;
	}

	public function setItemActivityDirectMatching($itemActivityDirectMatching) {
		$this->_itemActivityDirectMatching = $itemActivityDirectMatching;
		return true;
	}

	public function getItemActivityDirectMatching() {
		return $this->_itemActivityDirectMatching;
	}

	// Main:
	
	public function init() {
		parent::init();
		if (!$this->_autoRender) {
			$this->items = $this->normalizeItemsForView($this->items);
		}
	}

	public function run() {
		if ($this->_autoRender) {
			parent::run();
		}
	}

	/**
	 * Normalizes the {@link items} property determining its actual URL, first and last items.
	 * @param array $items the items to be normalized
	 * @return array the normalized menu items
	 */
	protected function normalizeItemsForView($items) {
		$activeItemKey = null;
		foreach ($items as $itemKey => $item) {
			if (isset($item['items'])) {
				$items[$itemKey]['items'] = $this->normalizeItemsForView($item['items']);
			}
			$items[$itemKey]['url'] = CHtml::normalizeUrl($item['url']);
			if ($item['active']) {
				if ($activeItemKey !== null) {
					if (strlen($items[$itemKey]['url']) > strlen($items[$activeItemKey]['url'])) {
						$items[$activeItemKey]['active'] = false;
						$activeItemKey = $itemKey;
					} else {
						$items[$itemKey]['active'] = false;
					}
				} else {
					$activeItemKey = $itemKey;
				}
			}
		}
		$items[0]['first'] = true;
		$items[count($items)-1]['last'] = true;
		return $items;
	}

	/**
	 * Checks whether a menu item is active.
	 * This is done by checking if the currently requested URL is generated by the 'url' option
	 * of the menu item.
	 * If the item's url is a head part of the request URI, the item will be considered as active.
	 * @param array $item the menu item to be checked
	 * @param string $route the route of the current request
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item,$route) {
		if ($this->_itemActivityDirectMatching) {
			return parent::isItemActive($item,$route);
		}
		if (!array_key_exists('url',$item)) {
			return false;
		}

		if (!isset($_SERVER['REQUEST_URI']) || !isset($_SERVER['SCRIPT_NAME'])) {
			return false;
		}

		$itemUrl = CHtml::normalizeUrl($item['url']);

		$compareUri = $_SERVER['REQUEST_URI'].'/';

		$requestHead = dirname( $_SERVER['SCRIPT_NAME'] );
		$localItemUrl = trim( str_replace($requestHead, '', $itemUrl), '/' );
		if (empty($localItemUrl)) {
			$localRequestUri = trim( str_replace($requestHead, '', $compareUri), '/' );
			if (empty($localRequestUri)) {
				return true;
			} else {
				return false;
			}
		}

		if (strpos($compareUri.'/', $itemUrl.'/')===0) {
			return true;
		} else {
			return false;
		}
	}
}