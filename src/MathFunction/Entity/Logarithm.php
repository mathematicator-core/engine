<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction;


final class Logarithm implements MathFunction
{
	public function invoke($haystack, ...$params): float
	{
		return log((float) $haystack, (float) ($params[0][0] ?? 10));
	}
}
