<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction;


final class Sin implements MathFunction
{
	public function invoke($haystack, ...$params): float
	{
		return sin((float) $haystack);
	}
}