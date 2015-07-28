<?php

namespace App\Models;

use App\Models\Entities\User;
use ArrayAccess;
use Doctrine\Common\Collections\ArrayCollection;
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
	/**
	 * @var EntityDao
	 */
	private $userDao;

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->userDao = $em->getRepository(User::class);
		$this->em = $em;
	}

	/**
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
	 * @param string $username
	 * @param string $password
	 * @param string $fullname
	 */
	public function add($username, $password, $fullname)
	{
		$user = new User;
		$user->setUsername($username);
		$user->setPassword(Passwords::hash($password));
		$user->setFullname($fullname);

		$this->userDao->safePersist($user);
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		return $this->userDao->findAll();
	}

	/**
	 * @param int $userId
	 * @return User
	 */
	public function get($userId)
	{
		return $this->userDao->find($userId);
	}

	/**
	 * @param User $user
	 * @param array $albums
	 */
	public function assignAlbums(User $user, array $albums)
	{
		$user->albums->clear();

		$user->setAlbums($albums);

		$this->em->persist($user);
		$this->em->flush();
	}
}
