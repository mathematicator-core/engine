<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


final class Helpers
{

	/** @throws \Error */
	public function __construct()
	{
		throw new \Error('Class ' . get_class($this) . ' is static and cannot be instantiated.');
	}


	/**
	 * Starts/stops stopwatch.
	 *
	 * @param string $name
	 * @return float elapsed seconds
	 */
	public static function timer(string $name): float
	{
		static $time = [];
		$now = microtime(true);
		$delta = isset($time[$name]) ? $now - $time[$name] : 0;
		$time[$name] = $now;

		return $delta;
	}
}