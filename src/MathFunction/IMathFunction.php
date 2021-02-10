<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction;


interface IMathFunction
{
	public function invoke(mixed $haystack, mixed ...$params): mixed;
}
