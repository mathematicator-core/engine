<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Step;


final class Step
{
	private ?string $title;

	private ?string $latex;

	private ?string $description;

	private bool $htmlTitle = false;

	private bool $htmlDescription = false;

	private ?string $ajaxEndpoint = null;


	public function __construct(?string $title = null, ?string $latex = null, ?string $description = null)
	{
		$this->title = $title;
		$this->latex = $latex;
		$this->description = $description;
	}


	public function getTitle(): ?string
	{
		return $this->title;
	}


	public function setTitle(string $title = null, bool $html = false): void
	{
		$this->title = $title;
		$this->htmlTitle = $html;
	}


	public function isHtmlTitle(): bool
	{
		return $this->htmlTitle;
	}


	public function getLatex(): ?string
	{
		return $this->latex;
	}


	public function setLatex(?string $latex = null): void
	{
		$this->latex = $latex ?: null;
	}


	public function getDescription(): ?string
	{
		return $this->description;
	}


	public function setDescription(?string $description = null, bool $html = false): void
	{
		$this->description = $description;
		$this->htmlDescription = $html;
	}


	public function isHtmlDescription(): bool
	{
		return $this->htmlDescription;
	}


	public function getAjaxEndpoint(): ?string
	{
		return $this->ajaxEndpoint;
	}


	public function setAjaxEndpoint(string $ajaxEndpoint = null): void
	{
		$this->ajaxEndpoint = $ajaxEndpoint;
	}
}
