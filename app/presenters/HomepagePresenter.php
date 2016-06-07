<?php

namespace App\Presenters;

use App\Components\SmartLookFactory;
use App\PublicModule\Component\GoogleAnalytics;
use Nette;
use App\Model;
use App\Forms\SignUpFormFactory;
use Ublaboo\Mailing\MailFactory;


class HomepagePresenter extends BasePresenter
{

	/** @var SignUpFormFactory @inject */
	public $factory;

	/**
	 * @var boolean
	 */
	private $formSendedSuccess = FALSE;

	/**
	 * @var Model\Users
	 * @inject
	 */
	public $users;

	/**
	 * @var integer
	 */
	private $registrationsAvailable;

	/**
	 * @var MailFactory
	 * @inject
	 */
	public $mailFactory;

	/**
	 * @var SmartLookFactory
	 * @inject
	 */
	public $smartLook;

	/**
	 * @var GoogleAnalytics
	 * @inject
	 */
	public $googleAnalytics;

	/**
	 * HomepagePresenter constructor.
	 *
	 * @param int $registrationsAvailable
	 */
	public function __construct($registrationsAvailable)
	{
		$this->registrationsAvailable = $registrationsAvailable;
	}


	public function renderDefault()
	{
		$this->getTemplate()->formSended = $this->formSendedSuccess;
	}

	/**
	 * @return GoogleAnalytics
	 */
	protected function createComponentGoogleAnalytics()
	{
		return $this->googleAnalytics;
	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
		$form = $this->factory->create(function ($values) {

			if ($this->users->count() <= $this->registrationsAvailable) {
				$this->formSendedSuccess = 'regular';
				$this->mailFactory->createByType('\App\Mails\ConfirmRegular', ['recipient' => $values['mail']])->send();
			} else {
				$this->formSendedSuccess = 'spare';
				$this->mailFactory->createByType('\App\Mails\ConfirmSpare', ['recipient' => $values['mail']])->send();
			}

			$this->redrawControl('registration');
		}, function() {
			$this->redrawControl('registration');
		});
		return $form;
	}

	/**
	 * @return \App\Components\SmartLook
	 */
	protected function createComponentSmartLook()
	{
		return $this->smartLook->create();
	}

}
