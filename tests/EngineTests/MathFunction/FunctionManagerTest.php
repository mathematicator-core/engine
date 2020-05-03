<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\Engine\MathFunction\FunctionManager;
use Mathematicator\Engine\MathFunction\Sin;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

class FunctionManagerTest extends TestCase
{

	public function testBasic(): void
	{
		$sin = FunctionManager::getFunction('sin');

		Assert::type(Sin::class, $sin);
		Assert::type('array', FunctionManager::getFunctions());
		Assert::type('array', FunctionManager::getFunctionNames());
		Assert::contains('sin', FunctionManager::getFunctionNames());
		Assert::same('1', (string) $sin->invoke(M_PI_2));

		FunctionManager::addFunction('my-function', new Sin);

		Assert::exception(function () {
			FunctionManager::addFunction('cos', new Sin);
		}, \RuntimeException::class);

		Assert::exception(function () {
			FunctionManager::getFunction('unknown-function');
		}, \RuntimeException::class);
	}
}

(new FunctionManagerTest)->run();
