<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Mathematicator\Router\Router;
use Mathematicator\SearchController\IController;
use Nette\DI\Container;
use Tracy\Debugger;

final class Engine
{

	/**
	 * @var Router
	 */
	private $router;

	/**
	 * @var Container
	 */
	private $serviceFactory;

	/**
	 * @param Router $router
	 * @param Container $container
	 */
	public function __construct(Router $router, Container $container)
	{
		$this->router = $router;
		$this->serviceFactory = $container;
	}

	/**
	 * @param string $query
	 * @return EngineResult
	 * @throws InvalidDataException
	 */
	public function compute(string $query): EngineResult
	{
		if (preg_match('/^(?<left>.+?)\s+vs\.?\s+(?<right>.+?)$/', $query, $versus)) {
			return (new EngineMultiResult($query, null))
				->addResult($this->compute($versus['left']), 'left')
				->addResult($this->compute($versus['right']), 'right');
		}

		$callback = $this->router->routeQuery($query);
		$matchedRoute = (string) preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $callback);

		if ($result = $this->processCallback($query, $callback)) {
			$return = new EngineSingleResult(
				$query,
				$matchedRoute,
				$result->getInterpret(),
				$result->getBoxes(),
				$result->getSources()
			);
		} else {
			$return = new EngineSingleResult($query, $matchedRoute);
		}

		return $return->setTime((int) round(Debugger::timer('search_request') * 1000));
	}

	/**
	 * @param string $query
	 * @param string $callback
	 * @return IController|null
	 * @throws InvalidDataException
	 */
	private function processCallback(string $query, string $callback): ?IController
	{
		/** @var IController|null $return */
		$return = $this->serviceFactory->getByType($callback);

		if ($return !== null) {
			$return->setQuery($query);
			$return->resetBoxes();

			try {
				$return->actionDefault();
			} catch (TerminateException $e) {
			}
		}

		return $return ?? null;
	}

}
