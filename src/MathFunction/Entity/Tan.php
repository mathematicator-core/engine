<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction\Entity;


use Mathematicator\Engine\MathFunction\IMathFunction;

final class Tan implements IMathFunction
{
	public function invoke(mixed $haystack, mixed ...$params): float
	{
		return tan((float) $haystack);
	}
}
