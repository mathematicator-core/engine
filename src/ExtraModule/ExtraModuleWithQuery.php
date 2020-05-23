<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


interface ExtraModuleWithQuery extends ExtraModule
{
	public function setQuery(string $query): void;
}
