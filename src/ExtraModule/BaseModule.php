<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Symfony\Component\Translation\Translator;

abstract class BaseModule implements ExtraModuleWithQuery
{

	/**
	 * @var Translator
	 * @inject
	 */
	public $translator;

	/** @var EngineSingleResult */
	protected $result;

	/** @var string */
	protected $query;


	/**
	 * @param EngineSingleResult $result
	 * @return ExtraModule
	 * @internal
	 */
	final public function setEngineSingleResult(EngineSingleResult $result): ExtraModule
	{
		$this->result = $result;

		return $this;
	}


	/**
	 * @param string $query
	 * @internal
	 */
	final public function setQuery(string $query): void
	{
		$this->query = $query;
	}
}
