<?php

declare(strict_types=1);

namespace Mathematicator\Engine\MathFunction;


final class Tan implements MathFunction
{
	public function invoke($haystack): float
	{
		return tan((float) $haystack);
	}
}