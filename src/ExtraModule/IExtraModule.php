<?php

declare(strict_types=1);

namespace Mathematicator\Engine\ExtraModule;


use Mathematicator\Engine\Entity\EngineSingleResult;

interface IExtraModule
{

	/**
	 * @param EngineSingleResult $result
	 * @return IExtraModule
	 * @internal
	 */
	public function setEngineSingleResult(EngineSingleResult $result): self;

	/**
	 * @param string $query
	 * @return bool
	 */
	public function match(string $query): bool;

	public function actionDefault(): void;
}
