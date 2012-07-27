<?php

/**
 * Test case for the "static pages" functionality.
 * Test case ensures all static pages are accessible and display correct content.
 */
class StaticPageTest extends WebTestCase {
	public function testBrowseStaticPages() {
		$staticPages = StaticPage::model()->findAll();
		foreach($staticPages as $staticPage) {
			$this->open($staticPage->url_keyword);
			$this->assertTextPresent($staticPage->title, 'Could not find title of the static page "'.$staticPage->url_keyword.'"!');

			$pageMainContentHtml = $this->getHtmlSource();
			$staticPageNormalizedContent = strip_tags( str_replace( array("\n", "\r"), '', Yii::app()->format->formatEvalView($staticPage->content) ) );
			$pageMainNormalizedContentHtml = strip_tags( str_replace( array("\n", "\r"), '', $pageMainContentHtml ) );

			$this->assertContains($staticPageNormalizedContent, $pageMainNormalizedContentHtml, 'Could not find content of the static page "'.$staticPage->url_keyword.'"!');
		}
	}
}
