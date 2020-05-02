<?php

declare(strict_types=1);

namespace App;


use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Routing\Router;
use Nette\StaticClass;

class RouterFactory
{
	use StaticClass;

	/**
	 * @return Router
	 */
	public static function createRouter(): Router
	{
		$router = new RouteList;

		$router[] = self::createFrontRouter();

		return $router;
	}


	private static function createFrontRouter(): Router
	{
		$router = new RouteList('Front');

		$router[] = new Route('<presenter>/<action>', 'Homepage:default');

		return $router;
	}
}
