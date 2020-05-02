<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\Engine\Translator;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class TranslatorTest extends TestCase
{

	/** @var Translator */
	private $translator;


	public function __construct(Container $container)
	{
		$this->translator = $container->getByType(Translator::class);
	}


	/**
	 * @dataprovider getMessages
	 * @param string $expected
	 * @param mixed $message
	 * @param mixed[] $parameters
	 */
	public function testTranslator(string $expected, $message, array $parameters): void
	{
		Assert::same($expected, $this->translator->translate($message, $parameters));
	}


	/**
	 * @return string[]
	 */
	public function getMessages(): array
	{
		return [
			['256', 256, []],
			['Baraja', 'Baraja', []],
		];
	}
}

(new TranslatorTest(Bootstrap::boot()))->run();
