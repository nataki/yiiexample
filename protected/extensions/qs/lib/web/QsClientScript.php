<?php
/**
 * QsClientScript class file.
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @link http://www.quartsoft.com/
 * @copyright Copyright &copy; 2010-2013 QuartSoft ltd.
 * @license http://www.quartsoft.com/license/
 */

/**
 * QsClientScript is an extension of {@link CClientScript}, which manages JavaScript and CSS stylesheets for views.
 * This extension changes the meta tags management.
 * @see CClientScript
 *
 * @author Paul Klimov <pklimov@quartsoft.com>
 * @package qs.web
 */
class QsClientScript extends CClientScript {
	/**
	 * Registers a meta tag that will be inserted in the head section (right before the title element) of the resulting page.
	 *
	 * <b>Note:</b>
	 * Meta tags with same attributes will be rendered more then once if called with different values.
	 *
	 * <b>Example:</b>
	 * <pre>
	 *    $cs->registerMetaTag('example', 'description', null, array('lang' => 'en'));
	 *    $cs->registerMetaTag('beispiel', 'description', null, array('lang' => 'de'));
	 * </pre>
	 * @param string $content content attribute of the meta tag
	 * @param string $name name attribute of the meta tag. If null, the attribute will not be generated
	 * @param string $httpEquiv http-equiv attribute of the meta tag. If null, the attribute will not be generated
	 * @param array $options other options in name-value pairs (e.g. 'scheme', 'lang')
	 * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
	 */
	public function registerMetaTag($content, $name=null, $httpEquiv=null, $options=array()) {
		$this->hasScripts = true;
		if ($name !== null) {
			$options['name'] = $name;
		}
		if ($httpEquiv !== null) {
			$options['http-equiv'] = $httpEquiv;
		}
		$options['content'] = $content;
		$this->metaTags[] = $options;
		$params = func_get_args();
		$this->recordCachingAction('clientScript', 'registerMetaTag', $params);
		return $this;
	}

	/**
	 * Registers a meta tag that will be inserted in the head section (right before the title element) of the resulting page.
	 *
	 * <b>Note:</b>
	 * Unlike the {@link registerMetaTag()} this method allows replacement of the meta tag content.
	 * This means: if you call this method with the same meta tag name and options but different content multiply times -
	 * only one meta tag will be rendered with the last given content.
	 *
	 * <b>Example:</b>
	 * <pre>
	 *    $cs->registerMetaTag('example', 'description', null, array('lang' => 'en'));
	 *    $cs->registerMetaTag('beispiel', 'description', null, array('lang' => 'de')); // register new meta tag
	 *    $cs->registerMetaTag('overridden', 'description', null, array('lang' => 'en')); // overwrite meta tag
	 * </pre>
	 * @param string $content content attribute of the meta tag
	 * @param string $name name attribute of the meta tag. If null, the attribute will not be generated
	 * @param string $httpEquiv http-equiv attribute of the meta tag. If null, the attribute will not be generated
	 * @param array $options other options in name-value pairs (e.g. 'scheme', 'lang')
	 * @return CClientScript the CClientScript object itself.
	 */
	public function registerMetaTagUnique($content, $name=null, $httpEquiv=null, $options=array()) {
		$this->hasScripts = true;
		if ($name !== null) {
			$options['name'] = $name;
		}
		if ($httpEquiv !== null) {
			$options['http-equiv'] = $httpEquiv;
		}
		ksort($options, SORT_STRING);
		$metaTagKey = serialize($options);
		$options['content'] = $content;
		$this->metaTags[$metaTagKey] = $options;
		$params = func_get_args();
		$this->recordCachingAction('clientScript', 'registerMetaTagUnique', $params);
		return $this;
	}
}
