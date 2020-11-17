<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Entity;


final class DynamicConfiguration
{
	private string $key;

	private ?string $title = null;

	/** @var string[]|null[] */
	private array $data = [];

	/** @var string[]|null[] */
	private array $defaults = [];

	/** @var string[] */
	private array $labels = [];


	public function __construct(string $key)
	{
		$this->key = $key;
	}


	public function getKey(): string
	{
		return $this->key;
	}


	public function getTitle(): ?string
	{
		return $this->title;
	}


	public function setTitle(?string $title): self
	{
		$this->title = $title;

		return $this;
	}


	public function getSerialized(): string
	{
		$return = '';
		foreach ($this->data as $key => $value) {
			if (($value = trim((string) $value)) !== '') {
				$return .= ($return ? '&' : '') . urlencode($key) . '=' . urlencode($value);
			}
		}

		return $return;
	}


	public function getValue(string $key, ?string $default = null): ?string
	{
		$this->defaults[$key] = $default;

		return $this->data[$key] ?? $default;
	}


	/**
	 * @return string[]|null[]
	 */
	public function getValues(): array
	{
		$return = $this->data;
		foreach ($this->defaults as $key => $value) {
			if ($value !== null || isset($this->data[$key]) === false) {
				$return[$key] = $value;
			}
		}

		return $return;
	}


	/**
	 * @return string[]
	 */
	public function getLabels(): array
	{
		return $this->labels;
	}


	public function getLabel(string $key): string
	{
		return $this->labels[$key] ?? $key;
	}


	public function addLabel(string $key, ?string $label): self
	{
		if ($label === null && isset($this->labels[$key])) {
			unset($this->labels[$key]);
		}
		if ($label !== null) {
			$this->labels[$key] = $label;
		}

		return $this;
	}


	/**
	 * @param string[]|null[] $haystack
	 * @return self
	 */
	public function setValues(array $haystack): self
	{
		foreach ($haystack as $key => $value) {
			if (isset($this->data[$key]) === false) {
				$this->data[$key] = ((string) $value) ?: null;
			}
		}

		return $this;
	}


	public function setValue(string $key, ?string $value = null): self
	{
		$this->data[$key] = $value;

		return $this;
	}
}
