<?php
	/**
	 * Created by PhpStorm.
	 * User: horacekp
	 * Date: 24/05/16
	 * Time: 12:13
	 */

	namespace App\Model;


	use App\Entity\User;
	use Kdyby\Doctrine\EntityManager;

	class Users
	{

		/**
		 * @var EntityManager
		 */
		private $em;

		/**
		 * Users constructor.
		 *
		 * @param EntityManager $em
		 */
		public function __construct(EntityManager $em)
		{
			$this->em = $em;
		}


		/**
		 * @param string $name
		 * @param string $email
		 * @param string $phone
		 *
		 * @return bool
		 */
		public function create($name, $email, $phone)
		{
			$user = new User($name, $email, $phone);
			$this->em->persist($user)->flush();

			return TRUE;
		}

		/**
		 * @return int
		 */
		public function count()
		{
			return $this->userRepository()->countBy([]);
		}

		/**
		 * @param $email
		 *
		 * @return bool
		 * @throws \Doctrine\ORM\NonUniqueResultException
		 */
		public function isUniqueEmail($email)
		{
			$result = $this->userRepository()->createQueryBuilder('u')
				->select('partial u.{id}')
				->where('u.email = :email')
				->setParameter('email', $email)
				->setMaxResults(1)
				->getQuery()->getOneOrNullResult();

			return is_null($result) ? TRUE : FALSE;
		}

		/**
		 * @return \Kdyby\Doctrine\EntityRepository
		 */
		public function userRepository()
		{
			return $this->em->getRepository('App\Entity\User');
		}

	}