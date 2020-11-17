<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Entity;


use Nette\Utils\Validators;

final class Source
{
	private ?string $title;

	/** @var string[] */
	private array $authors = [];

	private ?string $description;

	private ?string $url;


	public function __construct(?string $title = null, ?string $url = null, ?string $description = null)
	{
		$this->title = $title;
		$this->url = $url;
		$this->description = $description;
	}


	public function render(): string
	{
		$return = [];
		if ($this->title) {
			$title = htmlspecialchars($this->title, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
			if ($this->url !== null && Validators::isUrl($this->url)) {
				$return[] = '<a href="' . $this->url . '" target="_blank">' . $title . '</a>';
			} else {
				$return[] = '<b>' . $title . '</b>';
			}
		}
		if ($this->description) {
			$return[] = htmlspecialchars($this->description, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
		}
		if ($this->authors !== []) {
			$authors = [];
			foreach ($this->authors as $author) {
				$authors[] = htmlspecialchars($author, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
			}

			$return[] = 'Authors:<br><span class="text-secondary">- ' . implode('<br>- ', $authors) . '</span>';
		}

		return implode('<br>', $return);
	}


	public function __toString(): string
	{
		return $this->render();
	}


	public function addAuthor(string $author): self
	{
		$this->authors[] = $author;

		return $this;
	}


	/**
	 * @param string[] $authors
	 */
	public function setAuthors(array $authors): self
	{
		foreach ($authors as $author) {
			$this->addAuthor($author);
		}

		return $this;
	}


	public function setUrl(string $url): self
	{
		$this->url = $url;

		return $this;
	}


	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}


	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}
}
