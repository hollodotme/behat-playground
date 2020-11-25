<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

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
		if ( (float)$totalPrice !== $this->basket->getTotalPrice() )
		{
			throw new RuntimeException( 'Nope' );
		}
	}
}
