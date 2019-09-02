<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Mathematicator\Router\Router;
use Mathematicator\Search\Query;
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
	 * @var QueryNormalizer
	 */
	private $queryNormalizer;

	/**
	 * @var Container
	 */
	private $serviceFactory;

	/**
	 * @param Router $router
	 * @param QueryNormalizer $queryNormalizer
	 * @param Container $container
	 */
	public function __construct(Router $router, QueryNormalizer $queryNormalizer, Container $container)
	{
		$this->router = $router;
		$this->queryNormalizer = $queryNormalizer;
		$this->serviceFactory = $container;
	}

	/**
	 * @param string $query
	 * @return EngineResult|EngineMultiResult
	 * @throws InvalidDataException
	 */
	public function compute(string $query): EngineResult
	{
		$queryEntity = $this->buildQuery($query);

		if (preg_match('/^(?<left>.+?)\s+vs\.?\s+(?<right>.+?)$/', $queryEntity->getQuery(), $versus)) {
			return (new EngineMultiResult($queryEntity->getQuery(), null))
				->addResult($this->compute($versus['left']), 'left')
				->addResult($this->compute($versus['right']), 'right');
		}

		$controller = $this->router->routeQuery($queryEntity->getQuery());
		$matchedRoute = (string) preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $controller);

		if ($result = $this->processCallback($queryEntity, $controller)) {
			$return = new EngineSingleResult(
				$queryEntity->getQuery(),
				$matchedRoute,
				$result->getContext()->getInterpret(),
				$result->getContext()->getBoxes(),
				$result->getContext()->getSources()
			);
		} else {
			$return = new EngineSingleResult($queryEntity->getQuery(), $matchedRoute);
		}

		return $return->setTime((int) (Debugger::timer('search_request') * 1000));
	}

	/**
	 * @param Query $query
	 * @param string $controller
	 * @return IController|null
	 * @throws InvalidDataException
	 */
	private function processCallback(Query $query, string $controller): ?IController
	{
		/** @var IController|null $return */
		$return = $this->serviceFactory->getByType($controller);

		if ($return !== null) {
			$return->createContext($query);

			try {
				$return->actionDefault();
			} catch (TerminateException $e) {
			}
		}

		return $return ?? null;
	}

	/**
	 * @param string $query
	 * @return Query
	 */
	private function buildQuery(string $query): Query
	{
		return new Query(
			$query,
			$this->queryNormalizer->normalize($query)
		);
	}

}
