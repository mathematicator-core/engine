<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Entity;


abstract class EngineResult
{
	private string $query;

	private ?string $matchedRoute;

	private float $startTime;


	public function __construct(string $query, ?string $matchedRoute, ?float $startTime = null)
	{
		$this->query = $query;
		$this->matchedRoute = $matchedRoute;
		$this->startTime = $startTime ?? (float) microtime(true);
	}


	final public function getQuery(): string
	{
		return $this->query;
	}


	final public function getLength(): int
	{
		return mb_strlen($this->getQuery(), 'UTF-8');
	}


	final public function getMatchedRoute(): ?string
	{
		return $this->matchedRoute;
	}


	/**
	 * Return processing time in milliseconds.
	 */
	final public function getTime(): float
	{
		return (microtime(true) - $this->startTime) * 1000;
	}
}
