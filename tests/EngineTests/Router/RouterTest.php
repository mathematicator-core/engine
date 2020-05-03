<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\Engine\Controller\ErrorTooLongController;
use Mathematicator\Engine\Controller\OtherController;
use Mathematicator\Router\DynamicRoute;
use Mathematicator\Router\Router;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

class RouterTest extends TestCase
{

	public function testWithoutRoutes(): void
	{
		$router = new Router;

		Assert::same(OtherController::class, $router->routeQuery('1+1'));
	}


	public function testTooLongQuery(): void
	{
		$router = new Router;
		$query = str_repeat('1+', ErrorTooLongController::QUERY_LENGTH_LIMIT + 10) . '1';

		Assert::same(ErrorTooLongController::class, $router->routeQuery($query));
	}


	public function testRegexRoute(): void
	{
		$router = new Router;
		$router->addDynamicRoute(new DynamicRoute(DynamicRoute::TYPE_REGEX, 'now|today', 'TimeController'));

		Assert::same(OtherController::class, $router->routeQuery('yesterday'));
		Assert::same('TimeController', $router->routeQuery('now'));
	}


	public function testStaticRoute(): void
	{
		$router = new Router;
		$router->addDynamicRoute(new DynamicRoute(DynamicRoute::TYPE_STATIC, ['now'], 'TimeController'));

		Assert::same(OtherController::class, $router->routeQuery('yesterday'));
		Assert::same('TimeController', $router->routeQuery('now'));
	}


	public function testTokenizeRoute(): void
	{
		$router = new Router;
		$router->addDynamicRoute(new DynamicRoute(DynamicRoute::TYPE_TOKENIZE, '', 'CalculatorController'));

		Assert::same(OtherController::class, $router->routeQuery('now'));
		Assert::same('CalculatorController', $router->routeQuery('5+3'));
	}
}

(new RouterTest)->run();
