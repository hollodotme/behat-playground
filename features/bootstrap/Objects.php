<?php declare(strict_types=1);

final class Objects
{
	private FieldDefinitions $fieldDefinitions;

	private array $objects;

	private array $users;

	public function __construct( FieldDefinitions $fieldDefinitions, array $users )
	{
		$this->fieldDefinitions = $fieldDefinitions;
		$this->users            = $users;
		$this->objects          = [];
	}

	public function addObject( string $objectName, string $manufacturer, string $color ) : void
	{
		$this->objects[ $objectName ] = [
			'objectName'   => $this->fieldDefinitions->isFieldLocked( 'objectName' )
				? $this->fieldDefinitions->getDefaultValue( 'objectName' )
				: $objectName,
			'manufacturer' => $this->fieldDefinitions->isFieldLocked( 'manufacturer' )
				? $this->fieldDefinitions->getDefaultValue( 'manufacturer' )
				: $manufacturer,
			'color'        => $this->fieldDefinitions->isFieldLocked( 'color' )
				? $this->fieldDefinitions->getDefaultValue( 'color' )
				: $color,
		];
	}

	public function userAddsObject( string $username, string $objectName, string $manufacturer, string $color ) : void
	{
		if ( $this->users[ $username ]['ignoreLocks'] )
		{
			$this->objects[ $objectName ] = [
				'objectName'   => $objectName,
				'manufacturer' => $manufacturer,
				'color'        => $color,
			];

			return;
		}

		$this->addObject( $objectName, $manufacturer, $color );
	}

	public function getObject( string $objectName ) : array
	{
		return $this->objects[ $objectName ] ?? [];
	}
}