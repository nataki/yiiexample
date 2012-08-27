<?php

/**
 * Test case, which covers functionality related with the "F.A.Q." service.
 * Test case ensures this feature is accessible and working.
 */
class FaqTest extends WebTestCase {
	public function testFaq() {
		$this->open('help/faq');

		$this->assertTextPresent('F.A.Q');

		$faqCategories = FaqCategory::model()->findAll();
		foreach ($faqCategories as $faqCategoryNumber => $faqCategory) {
			$faqs = $faqCategory->faqs;
			foreach ($faqs as $faqNumber => $faq) {
				$this->assertTextPresent($faq->question);

				$elementNumber = $faqNumber+1;
				$this->assertFalse( $this->isVisible("xpath=//div[@id='faq_list_{$faqCategory->id}']/div[{$elementNumber}]"), 'FAQ content is expanded on the page load!' );
				$this->click("xpath=//div[@id='faq_list_{$faqCategory->id}']/h3[{$elementNumber}]/a");
				sleep(1);
				$this->assertTrue( $this->isVisible("xpath=//div[@id='faq_list_{$faqCategory->id}']/div[{$elementNumber}]"), 'FAQ content is not visible after its head clicked!' );

				$this->assertTextPresent($faq->answer);
			}
		}
	}
}
