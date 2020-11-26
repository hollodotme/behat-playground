<?php

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class LoggedInUserContext implements Context
{
	private $fieldDefinitions;

	private $objects;

	private $users = [
		'import' => [
			'ignoreLocks' => true,
		],
		'susann' => [
			'ignoreLocks' => false,
		],
	];

	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct()
	{
		# TODO: Implement login for user
		# TODO: Provide logged in user instance

		assert_options( ASSERT_ACTIVE, 1 );
		assert_options( ASSERT_EXCEPTION, 1 );
		assert_options( ASSERT_WARNING, 0 );

		$this->fieldDefinitions = new FieldDefinitions();
		$this->objects          = new Objects( $this->fieldDefinitions, $this->users );
	}

	/**
	 * @Given /^there is an object "([^"]*)" with manufacturer "([^"]*)" and color "([^"]*)"$/
	 */
	public function thereIsAnObjectWithManufacturerAndColor( $objectName, $manufacturer, $color )
	{
		$this->objects->addObject( $objectName, $manufacturer, $color );
	}

	/**
	 * @When /^I lock the field value for "([^"]*)" and set its default value to "([^"]*)"$/
	 */
	public function iLockTheFieldValueForAndSetItsDefaultValueTo( $fieldName, $defaultValue )
	{
		$this->fieldDefinitions->lockField( $fieldName, $defaultValue );
	}

	/**
	 * @Given /^the user "([^"]*)" adds an object "([^"]*)" with manufacturer "([^"]*)" and color "([^"]*)"$/
	 */
	public function theUserAddsAnObjectWithManufacturerAndColor( $user, $objectName, $manufacturer, $color )
	{
		$this->objects->userAddsObject( $user, $objectName, $manufacturer, $color );
	}

	/**
	 * @Then /^I can still edit the field "([^"]*)"$/
	 */
	public function iCanStillEditTheField( $fieldName )
	{
		assert( $this->fieldDefinitions->isFieldLocked( $fieldName ) === false );
	}

	/**
	 * @Given /^the object "([^"]*)" has the color "([^"]*)"$/
	 */
	public function theObjectHasTheColor( $objectName, $expectedColor )
	{
		assert( $this->objects->getObject( $objectName )['color'] === $expectedColor );
	}

}
