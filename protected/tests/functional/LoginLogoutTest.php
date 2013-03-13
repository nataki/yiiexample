<?php
 
/**
 * Test case, which covers 'login/logout' functionality.
 */
class LoginLogoutTest extends WebTestCase {
	public function tearDown() {
		$attributes = array(
			'name' => $this->getTestUserName()
		);
		$model = Member::model()->findByAttributes($attributes);
		if (!empty($model)) {
			$model->delete();
		}
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

	/**
	 * Registers user with the test data created with {@link getTestUserData()}
	 * in the database, so its credentials can be used for the login.
	 * @return CActiveRecord new user model.
	 */
	protected function registerTestUser() {
		$userData = $this->getTestUserData();

		$testUser = new Member();
		$testUser->status_id = User::STATUS_ACTIVE;
		$testUser->name = $userData['name'];
		$testUser->email = $userData['email'];
		$testUser->new_password = $userData['password'];
		$testUser->new_password_repeat = $userData['password'];
		$testUser->first_name = $userData['first_name'];
		$testUser->last_name = $userData['last_name'];
		$testUser->save(false);

		return $testUser;
	}

	/**
	 * Submits the login form.
	 * This is helper method for the internal tests.
	 * @param boolean $waitForPageLoad indicates if page load should be expected.
	 * @return boolean - success.
	 */
	protected function submitLoginForm($waitForPageLoad=true) {
		$submitLocator = "//input[@value='Login']";
		if ($waitForPageLoad) {
			$this->clickAndWait($submitLocator);
		} else {
			$this->click($submitLocator);
			sleep(1);
		}
		return true;
	}

	// Tests:

	public function testLoginFormAppearance() {
		$this->open('');

		// Login Form Should be accessible with the link titled "Login"
		$this->clickAndWait('link=Login');

		$this->assertTextPresent('Login');
		$this->assertElementPresent('name=LoginFormIndex[username]');
		$this->assertElementPresent('name=LoginFormIndex[password]');
	}

	/**
	 * @depends testLoginFormAppearance
	 */
	public function testLoginFormValidation() {
		$this->open('site/login');

		$submitLocator = "//input[@value='Login']";
		$this->click($submitLocator);

		$this->submitLoginForm(false);
		$this->assertTextPresent('Username or email cannot be blank');
		$this->assertTextPresent('Password cannot be blank');

		$unexistingUserName = get_class($this).'_'.uniqid();
		$this->type('name=LoginFormIndex[username]', $unexistingUserName);
		$this->type('name=LoginFormIndex[password]', $unexistingUserName.'_password');
		$this->submitLoginForm();
		$this->assertTextPresent('Incorrect username or password');
	}

	/**
	 * @depends testLoginFormValidation
	 */
	public function testLoginLogout() {
		$this->open('site/login');

		// Login:
		$testUser = $this->registerTestUser();
		$this->type('name=LoginFormIndex[username]', $testUser->name);
		$this->type('name=LoginFormIndex[password]', $testUser->new_password);
		$this->submitLoginForm();
		$this->assertTextPresent('Logout');
		$this->assertTextPresent($testUser->name);

		// Logout:
		$this->clickAndWait("link=Logout ({$testUser->name})");
		$this->assertTextNotPresent('Logout');
		$this->assertTextPresent('Login');
	}
}
