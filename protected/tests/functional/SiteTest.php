<?php

/**
 * Test case, which covers most common site pages and functionality,
 * such as 'home page'.
 */
class SiteTest extends WebTestCase {
	public function testIndex() {
		$this->open('');
		$this->assertTextPresent('Welcome');
	}
}
