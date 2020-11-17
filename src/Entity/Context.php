<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Entity;


use Mathematicator\Engine\Exception\TerminateException;
use Mathematicator\Engine\Helpers;

final class Context
{
	public const BOXES_LIMIT = 100;

	private string $query;

	private Query $queryEntity;

	/** @var Box[] */
	private array $boxes = [];

	/** @var Source[] */
	private array $sources = [];

	/** @var DynamicConfiguration[] */
	private array $dynamicConfigurations = [];

	private ?Box $interpret = null;


	public function __construct(Query $query)
	{
		$this->query = $query->getQuery();
		$this->queryEntity = $query;
	}


	public function getQuery(): string
	{
		return $this->query;
	}


	public function getQueryEntity(): Query
	{
		return $this->queryEntity;
	}


	/**
	 * @throws TerminateException
	 */
	public function addBox(string $type): Box
	{
		if (\count($this->boxes) >= self::BOXES_LIMIT) {
			throw new TerminateException(__METHOD__);
		}

		$this->boxes[] = ($box = new Box($type));

		return $box;
	}


	/**
	 * @return Box[]
	 */
	public function getBoxes(): array
	{
		return $this->boxes ?? [];
	}


	/**
	 * @return Source[]
	 */
	public function getSources(): array
	{
		return $this->sources;
	}


	/**
	 * @internal
	 */
	public function resetBoxes(): void
	{
		$this->boxes = [];
	}


	public function getInterpret(): ?Box
	{
		return $this->interpret;
	}


	public function setInterpret(string $boxType, ?string $content = null): Box
	{
		return $this->interpret = (new Box($boxType, 'Interpretace zadání dotazu', $content))
			->setIcon('fas fa-project-diagram');
	}


	public function addSource(Source $source): void
	{
		$this->sources[] = $source;
	}


	public function getDynamicConfiguration(string $key): DynamicConfiguration
	{
		if (isset($this->dynamicConfigurations[$key]) === false) {
			$this->dynamicConfigurations[$key] = new DynamicConfiguration($key);
		}

		return $this->dynamicConfigurations[$key];
	}


	/**
	 * @return DynamicConfiguration[]
	 */
	public function getDynamicConfigurations(): array
	{
		return $this->dynamicConfigurations;
	}


	/**
	 * Generate absolute URL to result page by given query.
	 * Route is defined by internal convention, in future it can be changed.
	 */
	public function link(string $query): string
	{
		return Helpers::getBaseUrl() . '/search' . (($query = trim($query)) !== '' ? '?q=' . urlencode($query) : '');
	}
}
