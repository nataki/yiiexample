<?php

/**
 * Test case, which covers most common site pages and functionality,
 * such as 'home page', 'login/logout'.
 */
class SiteTest extends WebTestCase {
	public function testIndex() {
		$this->open('');
		$this->assertTextPresent('Welcome');
	}

	public function testLoginLogout() {
		$this->open('');
		// ensure the user is logged out
		if($this->isTextPresent('Logout')) {
		    $this->clickAndWait('link=Logout');
        }

		// test login process, including validation
		$this->clickAndWait('link=Login');
		$this->assertElementPresent('name=LoginForm[username]');
		$this->type('name=LoginForm[username]','demo');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertTextPresent('Password cannot be blank.');
		$this->type('name=LoginForm[password]','demo');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertTextNotPresent('Password cannot be blank.');
		
        
        $testUserName = 'admin';
        $testUserPassword = 'admin';        
        $this->type('name=LoginForm[username]',$testUserName);
        $this->type('name=LoginForm[password]',$testUserPassword);
        $this->clickAndWait("//input[@value='Login']");        
        $this->assertTextPresent('Logout');

		// test logout process
		$this->assertTextNotPresent('Login');
		$this->clickAndWait("link=Logout ({$testUserName})");
		$this->assertTextPresent('Login');
	}
}
