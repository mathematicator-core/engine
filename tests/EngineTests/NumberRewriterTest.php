<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\NumberRewriter;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class NumberRewriterTest extends TestCase
{

	/** @var NumberRewriter */
	private $numberRewriter;

	public function __construct(Container $container)
	{
		$this->numberRewriter = $container->getByType(NumberRewriter::class);
	}


	/**
	 * @dataprovider getNumberRewriterToNumber
	 * @param string $expected
	 * @param string $query
	 */
	public function testNumberRewriterToNumber(string $expected, string $query): void
	{
		Assert::same($expected, $this->numberRewriter->toNumber($query));
	}


	/**
	 * @return string[]
	 */
	public function getNumberRewriterToNumber(): array
	{
		return [
			['5', 'pět'],
			['2 a 3', 'dva a tři'],
		];
	}
}

(new NumberRewriterTest(Bootstrap::boot()))->run();
