<?php

namespace App\Forms;

use App\Model\Users;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Nette\Application\UI\Form;


class SignUpFormFactory extends Nette\Object
{
	/** @var FormFactory */
	private $factory;

	/**
	 * @var callable
	 */
	private $onSuccess;

	/**
	 * @var callable
	 */
	private $onError;

	/**
	 * @type Users
	 */
	private $users;

	public function __construct(FormFactory $factory, Users $users)
	{
		$this->factory = $factory;
		$this->users = $users;
	}

	/**
	 * @param callable $onSuccess
	 *
	 * @return Form
	 */
	public function create(callable $onSuccess = NULL, callable $onError = NULL)
	{
		$this->onSuccess = $onSuccess;
		$this->onError = $onError;

		$form = $this->factory->create();
		$form->addText('degree', 'Titul');

		$form->addText('name', 'Jméno, příjmení')
			->setRequired('Prosím, vyplň své jméno a příjmení.');

		$form->addText('phone', 'Telefon');

		$form->addText('mail', 'E-mail')
			->setRequired('Prosím, zadej svůj e-mail.')
			->addRule(Form::EMAIL, 'Zadej e-mail v platném formátu. Např. jan.novak@wunderman.cz');

		$form->addSubmit('register', 'Registrovat');

		$form->addCheckbox('terms', 'souhlasím se zpracováním údajů')
			->setRequired('Musíš souhlasit se zpracováním osobních údajů, jinak žádný masíčko nebude.');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		$form->onValidate[] = [$this, 'formValidate'];

		return $form;
	}

	/**
	 * @param Form $form
	 * @param $values
	 */
	public function formSucceeded(Form $form, $values)
	{
		$this->users->create($values['degree'], $values['name'], $values['mail'], $values['phone']);

		if (is_callable($this->onSuccess)) {
			$onSuccess = $this->onSuccess;
			$onSuccess($values);
		}
	}

	/**
	 * @param Form $form
	 * @param $values
	 */
	public function formValidate(Form $form, $values)
	{
		if (! $this->users->isUniqueEmail($values['mail'])) {
			$form->addError('Tento e-mail je již na hackathon zaregistrován.');
		}


		if (is_callable($this->onError)) {
			$onError = $this->onError;
			$onError();
		}
	}
}
