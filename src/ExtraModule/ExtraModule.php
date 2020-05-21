<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


interface ExtraModule
{

	/**
	 * @param EngineSingleResult $result
	 * @return ExtraModule
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
