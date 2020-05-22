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
	/**
	 * @var TranslatorInterface
	 */
	private $translator;


	public function __construct(
		Container $container
	)
	{
		$this->translator = $container->getByType(Translator::class);
	}

	public function testTranslate(): void
	{
		// Check simple translation
		Assert::same('Test', $this->translator->translate('test.test'));
	}

}

$container = (new Bootstrap())::boot();
(new TranslatorTest($container))->run();
