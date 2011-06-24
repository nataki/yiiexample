<?php

/**
 * Test case, which covers functionality related with the help system.
 * Test case ensures the help features are accessible and working.
 */
class HelpTest extends WebTestCase {
    public function testContact() {
        $this->open('help/contact');        
        
        $this->assertTextPresent('Contact Us');
        $this->assertElementPresent('name=ContactForm[name]');

        $this->type('name=ContactForm[name]','tester');
        $this->type('name=ContactForm[email]','tester@example.com');
        $this->type('name=ContactForm[subject]','test subject');
        $this->clickAndWait("//input[@value='Submit']");
        $this->assertTextPresent('Body cannot be blank.');
    }

    public function testFaq() {
        $this->open('help/faq');
        
        $this->assertTextPresent('F.A.Q');
        
        $faqCategories = FaqCategory::model()->findAll();
        foreach($faqCategories as $faqCategoryNumber => $faqCategory) {
            $faqs = $faqCategory->faqs;
            foreach($faqs as $faqNumber => $faq) {
                $this->assertTextPresent($faq->question);                                
                
                $elementNumber = $faqNumber+1;
                $this->assertFalse( $this->isVisible("xpath=//div[@id='faq_list_{$faqCategory->id}']/div[{$elementNumber}]"), 'FAQ content is expanded on the page load!' );
                $this->click("xpath=//div[@id='faq_list_{$faqCategory->id}']/h3[{$elementNumber}]/a");
                $this->assertTrue( $this->isVisible("xpath=//div[@id='faq_list_{$faqCategory->id}']/div[{$elementNumber}]"), 'FAQ content is not visible after its head clicked!' );
                
                $this->assertTextPresent($faq->answer);
            }
        }
    }
}
