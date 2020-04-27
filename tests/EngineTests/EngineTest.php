<?php declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\Engine\Engine;
use Mathematicator\Engine\EngineResult;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class EngineTest extends TestCase
{

	/**
	 * @var Engine
	 */
	private $engine;

	public function __construct(
		Container $container
	)
	{
		$this->engine = $container->getService('mathematicator.engine');
	}

	/**
	 * @dataprovider getComputeQueries
	 * @param string $query
	 */
	public function testCompute(string $query): void
	{
		$engineResult = $this->engine->compute($query);

		Assert::true($engineResult instanceof EngineResult); // TODO: Not easy to test
	}

	/**
	 * @return string[]
	 */
	public function getComputeQueries(): array
	{
		return [
			['123456789'],
		];
	}
}

$container = Bootstrap::boot();
(new EngineTest($container))->run();
