<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction;


final class Sqrt implements MathFunction
{
	public function invoke($haystack, ...$params): float
	{
		return sqrt((float) $haystack);
	}
}