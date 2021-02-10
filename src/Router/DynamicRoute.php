<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Router;


final class DynamicRoute
{
	public const TYPE_REGEX = 'regex';

	public const TYPE_STATIC = 'static';

	public const TYPE_TOKENIZE = 'tokenize';

	private string $type;

	private mixed $haystack;

	private string $controller;


	public function __construct(string $type, mixed $haystack, string $controller)
	{
		$this->type = $type;
		$this->haystack = $haystack;
		$this->controller = $controller;
	}


	public function getType(): string
	{
		return $this->type;
	}


	public function getHaystack(): mixed
	{
		return $this->haystack;
	}


	public function getController(): string
	{
		return $this->controller;
	}
}
