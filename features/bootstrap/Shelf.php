<?php declare(strict_types=1);

final class Shelf
{
	private array $priceMap = [];

	public function setProductPrice( string $product, float $price ) : void
	{
		$this->priceMap[ $product ] = $price;
	}

	public function getProductPrice( string $product ) : float
	{
		return $this->priceMap[ $product ] ?? 0.0;
	}
}