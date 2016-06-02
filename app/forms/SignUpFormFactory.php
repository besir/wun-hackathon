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
			->setRequired('Svůj šlechtický titul psát nemusíš, ale jméno se hodí :-)');

		$form->addText('phone', 'Telefon');

		$form->addText('mail', 'E-mail')
			->setRequired('Marná sláva, bez e-mailové adresy se dál nehneme :-)')
			->addRule(Form::EMAIL, 'Zadej e-mail v platném formátu. Např. jan.novak@wunderman.cz');

		$form->addSubmit('register', 'Registrovat');

		$form->addCheckbox('terms', 'souhlasím se zpracováním údajů')
			->setRequired('Nám je jasné, že se zpracováním údajů souhlasíš. Přesto je potřeba zaškrtnout ten malý čtvereček dole :-)');

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
