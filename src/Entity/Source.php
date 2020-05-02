<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Nette\SmartObject;
use Nette\Utils\Validators;

final class Source
{
	use SmartObject;

	/** @var string|null */
	private $title;

	/** @var string[] */
	private $authors = [];

	/** @var string|null */
	private $description;

	/** @var string|null */
	private $url;


	/**
	 * @param string|null $title
	 * @param string|null $url
	 * @param string|null $description
	 */
	public function __construct(?string $title = null, ?string $url = null, ?string $description = null)
	{
		$this->title = $title;
		$this->url = $url;
		$this->description = $description;
	}


	/**
	 * @return string
	 */
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


	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->render();
	}


	/**
	 * @param string $author
	 * @return Source
	 */
	public function addAuthor(string $author): self
	{
		$this->authors[] = $author;

		return $this;
	}


	/**
	 * @param string[] $authors
	 * @return Source
	 */
	public function setAuthors(array $authors): self
	{
		foreach ($authors as $author) {
			$this->addAuthor($author);
		}

		return $this;
	}


	/**
	 * @param string $url
	 * @return Source
	 */
	public function setUrl(string $url): self
	{
		$this->url = $url;

		return $this;
	}


	/**
	 * @param string $title
	 * @return Source
	 */
	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}


	/**
	 * @param string $description
	 * @return Source
	 */
	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}
}
