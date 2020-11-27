<?php declare(strict_types=1);

use Behat\Behat\Context\Context;

final class WebsiteContext implements Context
{
	private UserRepository $userRepository;

	private array $inputData = [];

	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct()
	{
		$this->userRepository = new UserRepository();
	}

	/** @BeforeFeature */
	public static function prepare() : void
	{
		assert_options( ASSERT_ACTIVE, 1 );
		assert_options( ASSERT_EXCEPTION, 1 );
		assert_options( ASSERT_WARNING, 0 );
	}

	/**
	 * @Given /^there is a user with username "([^"]*)" and password "([^"]*)"$/
	 * @param string $username
	 * @param string $password
	 */
	public function thereIsAUserWithUsernameAndPassword( string $username, string $password ) : void
	{
		$this->userRepository->addUser( $username, $password );
	}

	/**
	 * @When /^I enter the username "([^"]*)" to the user input field$/
	 * @param string $username
	 */
	public function iEnterTheUsernameToTheUserInputField( string $username ) : void
	{
		$this->inputData['username'] = $username;
	}

	/**
	 * @Given /^I enter the password "([^"]*)" to the password input field$/
	 * @param string $password
	 */
	public function iEnterThePasswordToThePasswordInputField( string $password ) : void
	{
		$this->inputData['password'] = $password;
	}

	/**
	 * @Then /^I should have logged in successfully$/
	 */
	public function iShouldHaveLoggedInSuccessfully() : void
	{
		$user = $this->userRepository->getUserByUsername( $this->inputData['username'] );

		assert( password_verify( $this->inputData['password'], $user['passwordHash'] ) );
	}

	/**
	 * @Then /^The login should fail$/
	 */
	public function theLoginShouldFail() : void
	{
		$user = $this->userRepository->getUserByUsername( $this->inputData['username'] );

		assert( !password_verify( $this->inputData['password'], $user['passwordHash'] ) );
	}
}
