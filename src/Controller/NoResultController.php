<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Controller;


use Mathematicator\Engine\Entity\Box;

final class NoResultController extends BaseController
{
	public function actionDefault(\Throwable $e): void
	{
		$this->addBox(Box::TYPE_HTML)
			->setTitle($this->translator->translate('engine.error.noResult.title'))
			->setText(
				'<p>' . $this->translator->translate('engine.error.noResult.message', [
					'query' => htmlspecialchars($this->getQuery(), ENT_QUOTES),
				]) . '</p>'
				. '<div class="alert alert-danger">'
				. '<b>' . $this->translator->translate('engine.error.noResult.exceptionMessage') . ':</b><br>'
				. htmlspecialchars($e->getMessage(), ENT_QUOTES)
				. '</div>'
			)
			->setIcon('fas fa-exclamation-triangle')
			->setTag('no-results');
	}
}
