<?php

/**
 * Test case, which covers functionality related with the "contact" service.
 * Test case ensures this feature is accessible and working.
 */
class ContactTest extends WebTestCase {
	public function testFormAppearance() {
		$this->open('help/contact');

		$this->assertTextPresent('Contact Us');
		$this->assertElementPresent('name=ContactForm[name]');
		$this->assertElementPresent('name=ContactForm[email]');
		$this->assertElementPresent('name=ContactForm[subject]');
		$this->assertElementPresent('name=ContactForm[body]');
		$this->assertElementPresent('name=ContactForm[verifyCode]');
	}

	/**
	 * @depends testFormAppearance
	 */
	public function testValidation() {
		$this->open('help/contact');

		$this->clickAndWait("//input[@value='Submit']");

		$this->assertTextPresent('Name cannot be blank');
		$this->assertTextPresent('Email cannot be blank');
		$this->assertTextPresent('Subject cannot be blank');
		$this->assertTextPresent('Body cannot be blank');
		$this->assertTextPresent('The verification code is incorrect');
	}

	/**
	 * @depends testValidation
	 */
	public function testSuccessfulSubmit() {
		$this->open('help/contact');

		$this->type('name=ContactForm[name]','tester');
		$this->type('name=ContactForm[email]','tester@example.com');
		$this->type('name=ContactForm[subject]','test subject');
		$this->type('name=ContactForm[body]','Test body');

		$captchaCode = $this->getCaptchaCode();
		$this->type('name=ContactForm[verifyCode]',$captchaCode);

		$this->clickAndWait("//input[@value='Submit']");

		$this->assertTextPresent('Thank you for contacting us');
	}
}
