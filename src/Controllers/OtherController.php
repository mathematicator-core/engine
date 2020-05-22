<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Controller;


use Mathematicator\Engine\Box;

final class OtherController extends BaseController
{
	public function actionDefault(): void
	{
		$this->addBox(Box::TYPE_HTML)
			->setTitle('&nbsp;')
			->setText(
				'<div style="padding:1em;background:#FEFEFE">'
				. '<h1>' . $this->translator->trans('ohNo', [], 'engine') . '</h1>'
				. '<p>' . $this->translator->trans('contentSearchFailed', [], 'engine') . '</p>'
				. '<div style="text-align:center;padding:4em 1em">'
				. '<img src="https://mathematicator.com/img/error_dinosaur.gif" alt="' . $this->translator->trans('contentSearchFailed', [], 'engine') . '">'
				. '</div>'
				. '</div>'
			)
			->setIcon('fas fa-exclamation-triangle')
			->setTag('no-results');

		$this->terminate();
	}
}
