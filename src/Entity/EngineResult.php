<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Nette\SmartObject;
use Nette\Utils\Strings;

abstract class EngineResult
{
	use SmartObject;

	/** @var string */
	private $query;

	/** @var string|null */
	private $matchedRoute;

	/** @var int */
	private $time;

	/** @var float */
	private $startTime;


	/**
	 * @param string $query
	 * @param string|null $matchedRoute
	 */
	public function __construct(string $query, ?string $matchedRoute)
	{
		$this->query = $query;
		$this->matchedRoute = $matchedRoute;
		$this->startTime = (float) microtime(true);
	}


	/**
	 * @return string
	 */
	final public function getQuery(): string
	{
		return $this->query;
	}


	/**
	 * @return int
	 */
	final public function getLength(): int
	{
		return Strings::length($this->getQuery());
	}


	/**
	 * @return string|null
	 */
	final public function getMatchedRoute(): ?string
	{
		return $this->matchedRoute;
	}


	/**
	 * Return processing time in milliseconds.
	 *
	 * @return float
	 */
	final public function getTime(): float
	{
		return (microtime(true) - $this->startTime) * 1000;
	}
}
