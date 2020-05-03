<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


abstract class BaseModule implements ExtraModule
{

	/** @var EngineSingleResult */
	protected $result;

	/** @var string */
	protected $query;


	/**
	 * @internal
	 * @param EngineSingleResult $result
	 * @return ExtraModule
	 */
	final public function setEngineSingleResult(EngineSingleResult $result): ExtraModule
	{
		$this->result = $result;

		return $this;
	}


	/**
	 * @internal
	 * @param string $query
	 */
	final public function setQuery(string $query): void
	{
		$this->query = $query;
	}
}
