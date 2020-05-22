<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


final class SampleModule extends BaseModule
{

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
				->setTitle($this->translator->trans('help', [], 'engine'))
				->setText($this->translator->trans('helpQuestion', [], 'engine'))
		);
	}
}
