<?php declare(strict_types=1);

use Behat\Behat\Context\Context;

final class FeatureContext implements Context
{
	private Shelf $shelf;

	private Basket $basket;

	public function __construct()
	{
		$this->shelf  = new Shelf();
		$this->basket = new Basket( $this->shelf );
	}

	/** @BeforeFeature */
	public static function prepare() : void
	{
		assert_options( ASSERT_ACTIVE, 1 );
		assert_options( ASSERT_EXCEPTION, 1 );
		assert_options( ASSERT_WARNING, 0 );
	}

	/**
	 * @Given there is a :arg1, which costs £:arg2
	 *
	 * @param string $product
	 * @param string $price
	 */
	public function thereIsAWhichCostsPs( string $product, string $price ) : void
	{
		$this->shelf->setProductPrice( $product, (float)$price );
	}

	/**
	 * @When I add the :product to the basket
	 *
	 * @param string $product
	 */
	public function iAddTheToTheBasket( string $product ) : void
	{
		$this->basket->addProduct( $product );
	}

	/**
	 * @Then I should have :count product(s) in the basket
	 *
	 * @param string $count
	 */
	public function iShouldHaveProductInTheBasket( string $count ) : void
	{
		if ( (int)$count !== $this->basket->count() )
		{
			throw new RuntimeException( 'Nope' );
		}
	}

	/**
	 * @Then the overall basket price should be £:totalPrice
	 *
	 * @param string $totalPrice
	 */
	public function theOverallBasketPriceShouldBePs( string $totalPrice ) : void
	{
		assert( (float)$totalPrice === $this->basket->getTotalPrice(), 'nope' );
	}
}
