<?php

declare(strict_types=1);


namespace Mathematicator\Engine\MathFunction;


final class Cos implements MathFunction
{
	public function invoke($haystack, ...$params): float
	{
		return cos((float) $haystack);
	}
}