<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Controller;


use Mathematicator\Engine\Box;
use Mathematicator\Engine\Query;
use Nette\Utils\Strings;

class ErrorTooLongController extends BaseController
{

	public function actionDefault(): void
	{
		$this->addBox(Box::TYPE_TEXT)
			->setTitle('Příliš dlouhý dotaz')
			->setText(
				'<p>Maximální délka vstupního dotazu je momentálně omezena na ' . Query::LENGTH_LIMIT . ' znaků (vloženo ' . Strings::length($this->getQuery()) . ' znaků) v kódování UTF-8.</p>'
				. '<p>Toto omezení nasazujeme z výkonnostních důvodů.</p>'
				. '<p>Pokud potřebujete vykonávat náročnější výpočty, kontaktujte nás.</p>'
			)
			->setIcon('fas fa-exclamation-triangle')
			->setTag('no-results');
	}
}
