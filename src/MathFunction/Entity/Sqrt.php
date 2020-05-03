<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction;


final class Sqrt implements MathFunction
{
	public function invoke($haystack): float
	{
		return sqrt((float) $haystack);
	}
}