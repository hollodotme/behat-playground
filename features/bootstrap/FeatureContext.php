<?php

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
	private $shelf;

	private $basket;

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

		$this->shelf  = new Shelf();
		$this->basket = new Basket( $this->shelf );
	}

	/**
	 * @Given there is a :arg1, which costs £:arg2
	 */
	public function thereIsAWhichCostsPs( $product, $price )
	{
		$this->shelf->setProductPrice( $product, $price );
	}

	/**
	 * @When I add the :product to the basket
	 */
	public function iAddTheToTheBasket( $product )
	{
		$this->basket->addProduct( $product );
	}

	/**
	 * @Then I should have :count product(s) in the basket
	 */
	public function iShouldHaveProductInTheBasket( $count )
	{
		if ( (int)$count !== $this->basket->count() )
		{
			throw new RuntimeException( 'Nope' );
		}
	}

	/**
	 * @Then the overall basket price should be £:totalPrice
	 */
	public function theOverallBasketPriceShouldBePs( $totalPrice )
	{
		assert( (float)$totalPrice === $this->basket->getTotalPrice(), 'nope' );
	}
}
