<?php

namespace App\Models;

use App\Models\Entities\User;
use Kdyby\Doctrine\EntityDao;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Nette\Security\AuthenticationException;
use Nette\Security\Identity;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserModel extends Nette\Object implements Nette\Security\IAuthenticator
{
	const
		TABLE_NAME = 'users',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'username',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_ROLE = 'role';


	/**
	 * @var EntityDao
	 */
	private $userDao;


	/**
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->userDao = $em->getRepository(User::class);
	}


	/**
	 * Performs an authentication.
	 *
	 * @param array $credentials
	 * @throws AuthenticationException
	 * @return Identity
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		/** @var User $user */
		$user = $this->userDao->findOneBy(['username' => $username]);

		if (!$user || !Passwords::verify($password, $user->getPassword())) {
			throw new AuthenticationException('Invalid username or password.', self::IDENTITY_NOT_FOUND);
		}

		return new Identity($user->getUserId(), NULL, $user->getLoginData());
	}


	/**
	 * Adds new user.
	 * @param $username
	 * @param $password
	 */
	public function add($username, $password)
	{
		$user = new User;
		$user->setUsername($username);
		$user->setPassword(Passwords::hash($password));
		$user->setFullname('Administrator');

		$this->userDao->safePersist($user);
	}

}
