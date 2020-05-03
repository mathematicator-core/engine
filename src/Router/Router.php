<?php

declare(strict_types=1);

namespace Mathematicator\Router;


use Mathematicator\Engine\Controller\ErrorTooLongController;
use Mathematicator\Engine\Controller\OtherController;
use Mathematicator\Engine\Engine;
use Mathematicator\Engine\MathFunction\FunctionManager;
use Mathematicator\Engine\Query;
use Mathematicator\Engine\TerminateException;
use Nette\Utils\Strings;

final class Router
{

	/** @var string */
	private $query;

	/** @var DynamicRoute[] */
	private $dynamicRoutes = [];


	/**
	 * @param string $query
	 * @return string
	 */
	public function routeQuery(string $query): string
	{
		$this->query = $query;
		$route = null;

		try {
			$this->process();
		} catch (TerminateException $e) {
			$route = $e->getMessage();
		}

		return $route ?? OtherController::class;
	}


	/**
	 * @param DynamicRoute $dynamicRoute
	 * @return Router
	 */
	public function addDynamicRoute(DynamicRoute $dynamicRoute): self
	{
		$this->dynamicRoutes[] = $dynamicRoute;

		return $this;
	}


	/**
	 * @throws TerminateException
	 */
	private function process(): void
	{
		$this->tooLongQueryRoute(ErrorTooLongController::class);

		foreach ($this->dynamicRoutes as $dynamicRoute) {
			if ($dynamicRoute->getType() === DynamicRoute::TYPE_REGEX) {
				$this->regexRoute($dynamicRoute->getHaystack(), $dynamicRoute->getController());
			} elseif ($dynamicRoute->getType() === DynamicRoute::TYPE_STATIC) {
				$this->staticRoute($dynamicRoute->getHaystack(), $dynamicRoute->getController());
			} elseif ($dynamicRoute->getType() === DynamicRoute::TYPE_TOKENIZE) {
				$this->tokenizeRoute($dynamicRoute->getController());
			}
		}
	}


	/**
	 * @param string $entity
	 * @throws TerminateException
	 */
	private function tooLongQueryRoute(string $entity): void
	{
		if (Strings::length($this->query) > Query::LENGTH_LIMIT) {
			throw new TerminateException($entity);
		}
	}


	/**
	 * @param string $regex
	 * @param string $entity
	 * @throws TerminateException
	 */
	private function regexRoute(string $regex, string $entity): void
	{
		if (preg_match('/^' . $regex . '$/', $this->query)) {
			throw new TerminateException($entity);
		}
	}


	/**
	 * @param string[] $queries
	 * @param string $entity
	 * @throws TerminateException
	 */
	private function staticRoute(array $queries, string $entity): void
	{
		static $queryCache = [];

		if (isset($queryCache[$this->query]) === false) {
			$queryCache[$this->query] = strtolower(trim(Strings::toAscii($this->query)));
		}

		if (\in_array($queryCache[$this->query], $queries, true) === true) {
			throw new TerminateException($entity);
		}
	}


	/**
	 * @param string $entity
	 * @throws TerminateException
	 */
	private function tokenizeRoute(string $entity): void
	{
		if (preg_match('/([\+\-\*\/\^\!])|INF[^a-zA-Z]|PI[^a-zA-Z]|<=>|<=+|>=+|!=+|=+|<>|>+|<+|(' . implode('\(|', FunctionManager::getFunctionNames()) . '\()/', $this->query, $match)) {
			throw new TerminateException($entity);
		}
	}
}
