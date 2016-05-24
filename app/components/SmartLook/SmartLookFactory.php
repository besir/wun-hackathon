<?php
	/**
	 * Created by PhpStorm.
	 * User: horacekp
	 * Date: 24/05/16
	 * Time: 16:06
	 */

	namespace App\Components;


	class SmartLookFactory
	{

		/**
		 * @var string
		 */
		private $code;

		/**
		 * SmartLookFactory constructor.
		 *
		 * @param string $code
		 */
		public function __construct($code)
		{
			$this->code = $code;
		}

		public function create()
		{
			return new SmartLook($this->code);
		}

	}