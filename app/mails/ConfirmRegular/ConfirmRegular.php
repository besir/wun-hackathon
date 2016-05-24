<?php

	namespace App\Mails;

	use Nette,
		Ublaboo\Mailing\Mail,
		Ublaboo\Mailing\IComposableMail;

	class ConfirmRegular extends Mail implements IComposableMail
	{

		/**
		 * There you will always have your mail addresses from configuration file
		 * @var array
		 */
		protected $mails;


		public function compose(Nette\Mail\Message $message, $params = NULL)
		{
			$this->setTemplateFile(realpath(__DIR__.'/mail.latte'));

			$message->setFrom($this->mails['defaultSender']);
			$message->addTo($params['recipient']);
		}
	}
