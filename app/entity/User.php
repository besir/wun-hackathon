<?php

	namespace App\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\ORM\Mapping\Table;

	/**
	 * @ORM\Entity
	 * @Table(name="user")
	 * @ORM\HasLifecycleCallbacks
	 */
	class User
	{

		/**
		 * @ORM\Id
		 * @ORM\GeneratedValue
		 * @ORM\Column(type="integer")
		 */
		protected $id;

		/**
		 * @ORM\Column(type="string")
		 */
		protected $degree;

		/**
		 * @ORM\Column(type="string", name="`name`")
		 */
		protected $name;

		/**
		 * @ORM\Column(type="string")
		 */
		protected $email;

		/**
		 * @ORM\Column(type="string")
		 */
		protected $phone;

		/**
		 * @ORM\Column(type="datetime")
		 */
		protected $registered;

		/**
		 * User constructor.
		 *
		 * @var string $degree
		 * @var string $name
		 * @var string $email
		 * @var string $phone
		 */
		public function __construct($degree, $name, $email, $phone)
		{
			$this->degree = $degree;
			$this->name = $name;
			$this->email = preg_replace('/\s+/', '', $email);
			$this->phone = $phone;
			$this->registered = new \DateTime();
		}
	}

	class InvalidUserException extends \Exception{};
