<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


final class SampleModule extends BaseModule
{

	/**
	 * @var Translator
	 * @inject
	 */
	public $translator;


	/**
	 * @param string $query
	 * @return bool
	 */
	public function match(string $query): bool
	{
		return $query === 'help';
	}


	public function actionDefault(): void
	{
		$this->result->addBox(
			(new Box(Box::TYPE_TEXT))
				->setTitle($this->translator->translate('Help'))
				->setText('What can I help you with?')
		);
	}
}
