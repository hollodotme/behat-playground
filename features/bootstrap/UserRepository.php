<?php declare(strict_types=1);

final class UserRepository
{
	private array $users = [];

	public function addUser( string $username, string $password ) : void
	{
		$this->users[ $username ] = password_hash( $password, PASSWORD_DEFAULT );
	}

	public function getUserByUsername( string $username ) : array
	{
		return [
			'username'     => $username,
			'passwordHash' => $this->users[ $username ] ?? '',
		];
	}
}