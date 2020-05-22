<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Baraja\Localization\Localization;
use Nette\Localization\ITranslator;

final class Translator implements ITranslator
{

	/** @var Localization */
	private $localization;


	/**
	 * @param Localization $localization
	 */
	public function __construct(Localization $localization)
	{
		$this->localization = $localization;
	}


	/**
	 * @param mixed $message
	 * @param mixed ...$parameters
	 * @return string
	 */
	public function translate($message, ...$parameters): string
	{
		// TODO: Implement me!
		return (string) $message;
	}
}
