<?php

/**
 * Test case for the "signup" process. 
 */
class SignupTest extends WebTestCase {
    /**
     * Submits signup form.
     * This is helper method for the internal tests.
     * @return boolean - success
     */
    protected function submitSignupForm() {
        $submitLocator = "//input[@value='Submit']";
        $this->clickAndWait($submitLocator);
        return true;
    }
    
    public function testSignupFormElements() {
        $this->open('signup');
        
        $this->assertTextPresent('signup');
        
        $this->assertElementPresent('name=Member[name]');
        $this->assertElementPresent('name=Member[email]');
        $this->assertElementPresent('name=Member[new_password]');
        $this->assertElementPresent('name=Member[new_password_repeat]');
        $this->assertElementPresent('name=MemberProfile[first_name]');
        $this->assertElementPresent('name=MemberProfile[last_name]');
        
        $this->submitSignupForm();
        $this->assertTextPresent('Username cannot be blank.');
        $this->assertTextPresent('Email cannot be blank.');
        $this->assertTextPresent('Password cannot be blank.');
        $this->assertTextPresent('First Name cannot be blank.');
        $this->assertTextPresent('Last Name cannot be blank.');
    }
    
    /**
     * @depends testSignupFormElements
     */
    public function testUsernameValidation() {
        $this->open('signup');
        
        $user = User::model()->find();
        if (!empty($user)) {
            $this->type('name=Member[name]',$user->name);
            $this->submitSignupForm();
            $this->assertTextPresent('"'.$user->name.'" has already been taken');
        }
    }
    
    /**
     * @depends testSignupFormElements
     */
    public function testEmailValidation() {
        $this->open('signup');
        
        $testEmail = 'invalid_email';
        $this->type('name=Member[email]',$testEmail);
        $this->submitSignupForm();
        $this->assertTextPresent('Email is not a valid email address.');
        
        $user = User::model()->find();
        if (!empty($user)) {
            $this->type('name=Member[email]',$user->email);
            $this->submitSignupForm();
            $this->assertTextPresent('"'.$user->email.'" has already been taken');
        }
    }
    
    /**
     * @depends testSignupFormElements
     */
    public function testPasswordValidation() {
        $this->open('signup');
        
        $testPassword = '123456';
        $testPasswordRepeat = $testPassword.'tail';
        $this->type('name=Member[new_password]',$testPassword);
        $this->type('name=Member[new_password_repeat]',$testPasswordRepeat);
        $this->submitSignupForm();
        $this->assertTextPresent('Password must be repeated exactly');
    }
}
