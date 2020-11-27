<?php declare(strict_types=1);

final class FieldDefinitions
{
	private array $definitions = [
		'objectName'   => [
			'fieldName' => 'objectName',
			'locked'    => false,
			'default'   => null,
		],
		'manufacturer' => [
			'fieldName' => 'manufacturer',
			'locked'    => false,
			'default'   => null,
		],
		'color'        => [
			'fieldName' => 'color',
			'locked'    => false,
			'default'   => null,
		],
	];

	public function lockField( string $fieldName, ?string $defaultValue = null ) : void
	{
		$this->definitions[ $fieldName ]['locked']  = true;
		$this->definitions[ $fieldName ]['default'] = $defaultValue;
	}

	public function unlockField( string $fieldName, ?string $defaultValue = null ) : void
	{
		$this->definitions[ $fieldName ]['locked']  = false;
		$this->definitions[ $fieldName ]['default'] = $defaultValue;
	}

	public function isFieldLocked( string $fieldName ) : bool
	{
		return (bool)$this->definitions[ $fieldName ]['locked'];
	}

	public function getDefaultValue( string $fieldName ) : ?string
	{
		return $this->definitions[ $fieldName ]['default'];
	}
}