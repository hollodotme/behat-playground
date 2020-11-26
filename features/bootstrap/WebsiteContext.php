<?php

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class WebsiteContext implements Context
{
	private $userRepository;

	private $inputData = [];

	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct()
	{
		assert_options( ASSERT_ACTIVE, 1 );
		assert_options( ASSERT_EXCEPTION, 1 );
		assert_options( ASSERT_WARNING, 0 );

		$this->userRepository = new UserRepository();
	}

	/**
	 * @Given /^there is a user with username "([^"]*)" and password "([^"]*)"$/
	 */
	public function thereIsAUserWithUsernameAndPassword( $username, $password )
	{
		$this->userRepository->addUser( $username, $password );
	}

	/**
	 * @When /^I enter the username "([^"]*)" to the user input field$/
	 */
	public function iEnterTheUsernameToTheUserInputField( $arg1 )
	{
		$this->inputData['username'] = $arg1;
	}

	/**
	 * @Given /^I enter the password "([^"]*)" to the password input field$/
	 */
	public function iEnterThePasswordToThePasswordInputField( $arg1 )
	{
		$this->inputData['password'] = $arg1;
	}

	/**
	 * @Then /^I should have logged in successfully$/
	 */
	public function iShouldHaveLoggedInSuccessfully()
	{
		$user = $this->userRepository->getUserByUsername( $this->inputData['username'] );

		assert( password_verify( $this->inputData['password'], $user['passwordHash'] ) );
	}

	/**
	 * @Then /^The login should fail$/
	 */
	public function theLoginShouldFail()
	{
		$user = $this->userRepository->getUserByUsername( $this->inputData['username'] );

		assert( !password_verify( $this->inputData['password'], $user['passwordHash'] ) );
	}
}
