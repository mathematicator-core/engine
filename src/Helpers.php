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


	/**
	 * @return string|null
	 */
	public static function getBaseUrl(): ?string
	{
		static $return;

		if ($return !== null) {
			return $return;
		}

		if (($currentUrl = self::getCurrentUrl()) !== null) {
			if (preg_match('/^(https?:\/\/.+)\/www\//', $currentUrl, $localUrlParser)) {
				$return = $localUrlParser[0];
			} elseif (preg_match('/^(https?:\/\/[^\/]+)/', $currentUrl, $publicUrlParser)) {
				$return = $publicUrlParser[1];
			}
		}

		if ($return !== null) {
			$return = rtrim($return, '/');
		}

		return $return;
	}


	/**
	 * Return current absolute URL.
	 * Return null, if current URL does not exist (for example in CLI mode).
	 *
	 * @return string|null
	 */
	public static function getCurrentUrl(): ?string
	{
		if (!isset($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST'])) {
			return null;
		}

		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
			. '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
}