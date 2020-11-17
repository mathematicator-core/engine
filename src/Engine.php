<?php

declare(strict_types=1);

namespace Mathematicator\Engine;


use Baraja\ServiceMethodInvoker;
use Mathematicator\Engine\Controller\Controller;
use Mathematicator\Engine\Controller\NoResultController;
use Mathematicator\Engine\Entity\EngineMultiResult;
use Mathematicator\Engine\Entity\EngineResult;
use Mathematicator\Engine\Entity\EngineSingleResult;
use Mathematicator\Engine\Entity\Query;
use Mathematicator\Engine\Exception\InvalidDataException;
use Mathematicator\Engine\Exception\TerminateException;
use Mathematicator\Engine\ExtraModule\IExtraModule;
use Mathematicator\Engine\ExtraModule\IExtraModuleWithQuery;
use Mathematicator\Engine\Router\Router;
use Nette\DI\Extensions\InjectExtension;
use Psr\Container\ContainerInterface;

final class Engine
{
	private Router $router;

	private QueryNormalizer $queryNormalizer;

	private ContainerInterface $container;

	/** @var IExtraModule[] */
	private array $extraModules = [];


	public function __construct(Router $router, QueryNormalizer $queryNormalizer, ContainerInterface $container)
	{
		$this->router = $router;
		$this->queryNormalizer = $queryNormalizer;
		$this->container = $container;
	}


	/**
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
					$extraModule->{$property} = $this->container->get($service);
				}
				if ($extraModule instanceof IExtraModuleWithQuery) {
					$extraModule->setQuery($queryEntity->getQuery());
				}
				$extraModule->actionDefault();
			}
		}

		return $result;
	}


	public function addExtraModule(IExtraModule $extraModule): void
	{
		$this->extraModules[] = $extraModule;
	}


	/**
	 * @throws InvalidDataException
	 */
	public function createNoResult(string $query, \Throwable $e): EngineSingleResult
	{
		$queryEntity = new Query($query, $this->queryNormalizer->normalize($query));
		$context = $this->invokeController($queryEntity, NoResultController::class, [
			'e' => $e,
		])->getContext();

		return new EngineSingleResult(
			$query, 'NoResultController', null, $context->getBoxes(), $context->getSources(), $queryEntity->getFilteredTags()
		);
	}


	/**
	 * @param mixed[] $defaultParameters
	 * @throws InvalidDataException
	 */
	private function invokeController(Query $query, string $serviceName, array $defaultParameters = []): Controller
	{
		/** @var Controller $controller */
		$controller = $this->container->get($serviceName);

		// 1. Inject services to public properties
		foreach (InjectExtension::getInjectProperties($serviceName) as $property => $service) {
			$controller->{$property} = $this->container->get($service);
		}

		// 2. Create context
		$controller->createContext($query);

		if (\method_exists($controller, 'actionDefault') === false) {
			throw new \RuntimeException($controller . ': Method "actionDefault" is required.');
		}
		try {
			(new ServiceMethodInvoker)->invoke($controller, 'actionDefault', $defaultParameters);
		} catch (TerminateException $e) {
		}

		return $controller;
	}
}
