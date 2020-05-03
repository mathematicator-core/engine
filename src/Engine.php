<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Mathematicator\Engine\Controller\Controller;
use Mathematicator\Router\Router;
use Nette\DI\Container;
use Nette\DI\Extensions\InjectExtension;

final class Engine
{

	/** @var Router */
	private $router;

	/** @var QueryNormalizer */
	private $queryNormalizer;

	/** @var Container */
	private $container;

	/** @var ExtraModule[] */
	private $extraModules = [];


	/**
	 * @param Router $router
	 * @param QueryNormalizer $queryNormalizer
	 * @param Container $container
	 */
	public function __construct(Router $router, QueryNormalizer $queryNormalizer, Container $container)
	{
		$this->router = $router;
		$this->queryNormalizer = $queryNormalizer;
		$this->container = $container;
	}


	/**
	 * @param string $query
	 * @return EngineResult
	 * @throws InvalidDataException
	 */
	public function compute(string $query): EngineResult
	{
		$queryEntity = new Query($query, $this->queryNormalizer->normalize($query));

		if (preg_match('/^(?<left>.+?)\s+(?:vs\.?|versus)\s+(?<right>.+?)$/', $queryEntity->getQuery(), $versus)) {
			return (new EngineMultiResult($queryEntity->getQuery()))
				->addResult($this->compute($versus['left']), 'left')
				->addResult($this->compute($versus['right']), 'right');
		}

		$controllerClass = $this->router->routeQuery($queryEntity->getQuery());
		$matchedRoute = (string) preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $controllerClass);
		$context = $this->invokeController($queryEntity, $controllerClass)->getContext();
		$result = new EngineSingleResult($queryEntity->getQuery(), $matchedRoute, $context->getInterpret(), $context->getBoxes(), $context->getSources(), $queryEntity->getFilteredTags());

		foreach ($this->extraModules as $extraModule) {
			if ($extraModule->setEngineSingleResult($result)->match($queryEntity->getQuery()) === true) {
				foreach (InjectExtension::getInjectProperties(\get_class($extraModule)) as $property => $service) {
					$extraModule->{$property} = $this->container->getByType($service);
				}
				if ($extraModule instanceof ExtraModuleWithQuery) {
					$extraModule->setQuery($queryEntity->getQuery());
				}
				$extraModule->actionDefault();
			}
		}

		return $result;
	}


	/**
	 * @param ExtraModule $extraModule
	 */
	public function addExtraModule(ExtraModule $extraModule): void
	{
		$this->extraModules[] = $extraModule;
	}


	/**
	 * @param Query $query
	 * @param string $serviceName
	 * @return Controller
	 * @throws InvalidDataException
	 */
	private function invokeController(Query $query, string $serviceName): Controller
	{
		/** @var Controller $controller */
		$controller = $this->container->getByType($serviceName);

		// 1. Inject services to public properties
		foreach (InjectExtension::getInjectProperties(\get_class($controller)) as $property => $service) {
			$controller->{$property} = $this->container->getByType($service);
		}

		// 2. Create context
		$controller->createContext($query);

		try {
			$controller->actionDefault();
		} catch (TerminateException $e) {
		}

		return $controller;
	}
}
