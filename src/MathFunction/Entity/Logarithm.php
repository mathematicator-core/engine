<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction;


final class Logarithm implements MathFunction
{
	public function invoke($haystack): float
	{
		return log((float) $haystack);
	}
}