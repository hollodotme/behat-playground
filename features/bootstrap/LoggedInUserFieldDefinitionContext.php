<?php declare(strict_types=1);

require __DIR__ . '/../../tools/phpunit';

use Behat\Behat\Context\Context;
use PHPUnit\Framework\TestCase;

final class LoggedInUserFieldDefinitionContext extends TestCase implements Context
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

	public function __construct( ?string $name = null, array $data = [], $dataName = '' )
	{
		parent::__construct( $name, $data, $dataName );

		$this->fieldDefinitions = new FieldDefinitions();
		$this->objects          = new Objects( $this->fieldDefinitions, $this->users );
	}

	/** @BeforeFeature */
	public static function prepare() : void
	{
		assert_options( ASSERT_ACTIVE, 1 );
		assert_options( ASSERT_EXCEPTION, 1 );
		assert_options( ASSERT_WARNING, 0 );
	}

	/**
	 * @Given /^there is an object "([^"]*)" with manufacturer "([^"]*)" and color "([^"]*)"$/
	 * @param string $objectName
	 * @param string $manufacturer
	 * @param string $color
	 */
	public function thereIsAnObjectWithManufacturerAndColor(
		string $objectName,
		string $manufacturer,
		string $color
	) : void
	{
		$this->objects->addObject( $objectName, $manufacturer, $color );
	}

	/**
	 * @When /^I lock the field value for "([^"]*)" and set its default value to "([^"]*)"$/
	 * @param string $fieldName
	 * @param string $defaultValue
	 */
	public function iLockTheFieldValueForAndSetItsDefaultValueTo( string $fieldName, string $defaultValue ) : void
	{
		$this->fieldDefinitions->lockField( $fieldName, $defaultValue );
	}

	/**
	 * @Given /^the user "([^"]*)" adds an object "([^"]*)" with manufacturer "([^"]*)" and color "([^"]*)"$/
	 * @param string $user
	 * @param string $objectName
	 * @param string $manufacturer
	 * @param string $color
	 */
	public function theUserAddsAnObjectWithManufacturerAndColor(
		string $user,
		string $objectName,
		string $manufacturer,
		string $color
	) : void
	{
		$this->objects->userAddsObject( $user, $objectName, $manufacturer, $color );
	}

	/**
	 * @Then /^I can still edit the field "([^"]*)"$/
	 * @param string $fieldName
	 */
	public function iCanStillEditTheField( string $fieldName ) : void
	{
		assert( $this->fieldDefinitions->isFieldLocked( $fieldName ) === false );
	}

	/**
	 * @Given /^the object "([^"]*)" has the color "([^"]*)"$/
	 * @param string $objectName
	 * @param string $expectedColor
	 */
	public function theObjectHasTheColor( string $objectName, string $expectedColor ) : void
	{
		$mock = $this->getMockBuilder( Countable::class )->getMockForAbstractClass();
		$mock->method( 'count' )->willReturn( 42 );

		self::assertSame( $expectedColor, $this->objects->getObject( $objectName )['color'] );
		self::assertCount( 42, $mock );
	}
}
