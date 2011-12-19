<?php

/**
 * Test case for the "signup" process. 
 */
class SignupTest extends WebTestCase {
    public function tearDown() {
        $attributes = array(
            'name'=>$this->getTestUserName()
        );
        $model = Member::model()->findByAttributes($attributes);
        if (!empty($model)) {
            $model->delete();
        }
    }

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

    /**
     * Returns the test user name, which should be used during the process testing.
     * @return string test user name.
     */
    protected function getTestUserName() {
        $testUserName = get_class($this).'_test_user';
        return $testUserName;
    }

    /**
     * Returns the test user data set.
     * @return array test user data.
     */
    protected function getTestUserData() {
        $testUserData = array(
            'name' => $this->getTestUserName(),
            'email' => $this->getTestUserName().'@somedomain.com',
            'password' => $this->getTestUserName().'_password',
            'first_name' => 'John',
            'last_name' => 'Test',
        );
        return $testUserData;
    }

    // Tests:
    
    public function testFormAppearance() {
        $this->open('signup');
        
        $this->assertTextPresent('signup');
        
        $this->assertElementPresent('name=SignupForm[name]');
        $this->assertElementPresent('name=SignupForm[email]');
        $this->assertElementPresent('name=SignupForm[new_password]');
        $this->assertElementPresent('name=SignupForm[new_password_repeat]');
        $this->assertElementPresent('name=SignupForm[first_name]');
        $this->assertElementPresent('name=SignupForm[last_name]');
        
        $this->submitSignupForm();
        $this->assertTextPresent('Username cannot be blank.');
        $this->assertTextPresent('Email cannot be blank.');
        $this->assertTextPresent('Password cannot be blank.');
        $this->assertTextPresent('First Name cannot be blank.');
        $this->assertTextPresent('Last Name cannot be blank.');
    }
    
    /**
     * @depends testFormAppearance
     */
    public function testUsernameValidation() {
        $this->open('signup');
        
        $user = User::model()->find();
        if (!empty($user)) {
            $this->type('name=SignupForm[name]',$user->name);
            $this->submitSignupForm();
            $this->assertTextPresent('"'.$user->name.'" has already been taken');
        }
    }
    
    /**
     * @depends testFormAppearance
     */
    public function testEmailValidation() {
        $this->open('signup');
        
        $testEmail = 'invalid_email';
        $this->type('name=SignupForm[email]',$testEmail);
        $this->submitSignupForm();
        $this->assertTextPresent('Email is not a valid email address.');
        
        $user = User::model()->find();
        if (!empty($user)) {
            $this->type('name=SignupForm[email]',$user->email);
            $this->submitSignupForm();
            $this->assertTextPresent('"'.$user->email.'" has already been taken');
        }
    }
    
    /**
     * @depends testFormAppearance
     */
    public function testPasswordValidation() {
        $this->open('signup');
        
        $testPassword = '123456';
        $testPasswordRepeat = $testPassword.'tail';
        $this->type('name=SignupForm[new_password]',$testPassword);
        $this->type('name=SignupForm[new_password_repeat]',$testPasswordRepeat);
        $this->submitSignupForm();
        $this->assertTextPresent('Password must be repeated exactly');
    }

    /**
     * @depends testUsernameValidation
     * @depends testEmailValidation
     * @depends testPasswordValidation
     */
    public function testSuccessfulSignup() {
        $this->open('signup');

        $userData = $this->getTestUserData();

        $this->type('name=SignupForm[name]',$userData['name']);
        $this->type('name=SignupForm[email]',$userData['email']);
        $this->type('name=SignupForm[first_name]',$userData['first_name']);
        $this->type('name=SignupForm[last_name]',$userData['last_name']);
        $this->type('name=SignupForm[new_password]',$userData['password']);
        $this->type('name=SignupForm[new_password_repeat]',$userData['password']);

        $captchaCode = $this->getCaptchaCode();
        $this->type('name=SignupForm[verifyCode]',$captchaCode);

        $this->submitSignupForm();
        $this->assertTextNotPresent('error');


        // Ensure new user has been created:
        $attributes = array(
            'name'=>$userData['name']
        );
        $model = Member::model()->findByAttributes($attributes);
        $this->assertTrue( is_object($model), 'No new user has been created!' );

        // Ensure the user is logged out:
		if($this->isTextPresent('Logout')) {
		    $this->open('site/logout');
        }

        // Login new user:
		$this->clickAndWait('link=Login');
		$this->type('name=LoginForm[username]',$userData['name']);
		$this->type('name=LoginForm[password]',$userData['password']);
		$this->clickAndWait("//input[@value='Login']");

        $this->assertTextPresent('Logout');
        $this->assertTextPresent($userData['name']);
    }
}
