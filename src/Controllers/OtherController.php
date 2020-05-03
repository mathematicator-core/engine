<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Controller;


use Mathematicator\Engine\Box;

class OtherController extends BaseController
{
	public function actionDefault(): void
	{
		$this->addBox(Box::TYPE_HTML)
			->setTitle('&nbsp;')
			->setText(
				'<div style="padding:1em;background:#FEFEFE">'
				. '<h1>Ale ne!</h1>'
				. '<p>Obsah se nepodařilo vyhledat…</p>'
				. '<div style="text-align:center;padding:4em 1em">'
				. '<img src="https://mathematicator.com/img/error_dinosaur.gif" alt="Content does not found">'
				. '</div>'
				. '</div>'
			)
			->setIcon('fas fa-exclamation-triangle')
			->setTag('no-results');
	}
}
