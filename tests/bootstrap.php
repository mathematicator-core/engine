<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;

// TODO: require __DIR__ . '/../vendor/autoload.php';


use Mathematicator\Engine\Translation\TranslatorHelper;
use Nette\Configurator;
use Nette\DI\Container;
use Tester\Environment;

Environment::setup();

class Bootstrap
{
	public static function boot(): Container
	{
		$configurator = new Configurator();

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__ . '/../src')
			->addDirectory(__DIR__ . '/Mocks')
			->register();

		$configurator
			->addConfig(__DIR__ . '/../common.neon')
			->addConfig(__DIR__ . '/test.common.neon');

		/** @var TranslatorHelper $translatorHelper */
		$translatorHelper = $container->getByType(TranslatorHelper::class);

		// Package translations
		$translatorHelper->addResource(__DIR__ . '/../translations', 'engine');

		// Translations for testing purposes
		$translatorHelper->addResource(__DIR__ . '/translations', 'test');

		// Set default language to english for tests for better understandability.
		$translatorHelper->translator->setLocale('en_US');

		$container = $configurator->createContainer();

		/** @var TranslatorHelper $translatorHelper */
		$translatorHelper = $container->getByType(TranslatorHelper::class);

		// Package translations
		$translatorHelper->addResource(__DIR__ . '/../translations', 'engine');

		// Translations for testing purposes
		$translatorHelper->addResource(__DIR__ . '/translations', 'test');

		// Set default language to english for tests for better understandability.
		$translatorHelper->translator->setLocale('en_US');

		return $container;
	}
}
