<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Error;
use function is_array;
use function is_callable;
use function is_object;

final class Helpers
{
	/** @throws Error */
	public function __construct()
	{
		throw new Error('Class ' . self::class . ' is static and cannot be instantiated.');
	}


	/** Convert dirty haystack to scalar haystack. If object implements __toString(), it will be called automatically. */
	public static function strictScalarType(mixed $haystack, bool $rewriteObjectsToString = true): mixed
	{
		if (is_array($haystack)) {
			$return = [];
			foreach ($haystack as $key => $value) {
				$return[$key] = self::strictScalarType($value, $rewriteObjectsToString);
			}

			return $return;
		}
		if (is_object($haystack) === true && is_callable($haystack) === false) {
			if ($rewriteObjectsToString === true && method_exists($haystack, '__toString')) {
				return (string) $haystack;
			}

			return get_class($haystack);
		}

		return $haystack;
	}
}
