<?php declare(strict_types=1);

use Behat\Behat\Context\Context;

class LoggedInUserTableContext implements Context
{
	private array $table;

	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct()
	{
		$this->table = [];
	}

	/** @BeforeFeature */
	public static function prepare() : void
	{
		assert_options( ASSERT_ACTIVE, 1 );
		assert_options( ASSERT_EXCEPTION, 1 );
		assert_options( ASSERT_WARNING, 0 );
	}

	/**
	 * @Given /^there is an object with name "([^"]*)"$/
	 * @param string $objectName
	 */
	public function thereIsAnObjectWithName( string $objectName ) : void
	{
		$this->table[] = $objectName;
	}

	/**
	 * @When /^I enter "([^"]*)" into the filter input$/
	 * @param string $filterTerm
	 */
	public function iEnterIntoTheFilterInput( string $filterTerm ) : void
	{
		$this->table = array_filter(
			$this->table,
			static function ( string $objerctName ) use ( $filterTerm )
			{
				return (bool)stristr( $objerctName, $filterTerm );
			}
		);
	}

	/**
	 * @Then /^I see (\d+) object in the list$/
	 * @param int $countObjects
	 */
	public function iSeeObjectInTheList( int $countObjects ) : void
	{
		assert( $countObjects === count( $this->table ) );
	}

	/**
	 * @Given /^I see the object with name "([^"]*)"$/
	 * @param string $objectName
	 */
	public function iSeeTheObjectWithName( string $objectName ) : void
	{
		assert( in_array( $objectName, $this->table, true ) );
	}

	/**
	 * @Given /^I don't see the object with name "([^"]*)"$/
	 * @param string $objectName
	 */
	public function iDonTSeeTheObjectWithName( string $objectName ) : void
	{
		assert( !in_array( $objectName, $this->table, true ) );
	}
}
