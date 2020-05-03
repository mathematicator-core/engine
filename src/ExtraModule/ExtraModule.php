<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


interface ExtraModule
{

	/**
	 * @internal
	 * @param EngineSingleResult $result
	 * @return ExtraModule
	 */
	public function setEngineSingleResult(EngineSingleResult $result): self;

	/**
	 * @param string $query
	 * @return bool
	 */
	public function match(string $query): bool;

	public function actionDefault(): void;
}
