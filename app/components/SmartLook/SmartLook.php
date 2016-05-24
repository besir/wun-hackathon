<?php
	/**
	 * Created by PhpStorm.
	 * User: horacekp
	 * Date: 24/05/16
	 * Time: 16:06
	 */

	namespace App\Components;


	use Nette\Application\UI\Control;

	class SmartLook extends Control
	{

		/**
		 * @var string
		 */
		private $code;

		/**
		 * SmartLook constructor.
		 *
		 * @param string $code
		 */
		public function __construct($code)
		{
			$this->code = $code;
		}

		public function render()
		{
			$this->getTemplate()->code = $this->code;
			$this->getTemplate()->setFile(__DIR__.'/templates/SmartLook.latte');
			$this->getTemplate()->render();
		}
	}