<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\Engine\DynamicConfiguration;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

class DynamicConfigurationTest extends TestCase
{

	public function testTranslator(): void
	{
		$config = new DynamicConfiguration('my-config');

		Assert::same('my-config', $config->getKey());
		Assert::same(null, $config->getTitle());

		$config->setTitle('My configuration');
		Assert::same('My configuration', $config->getTitle());

		Assert::same([], $config->getLabels());

		$config->addLabel('key', 'Value');
		Assert::same(['key' => 'Value'], $config->getLabels());

		$config->addLabel('key', null);
		Assert::same([], $config->getLabels());

		$config->setValues([
			'a' => '1',
			'b' => '2',
		]);

		$config->setValue('x', '256');
		$config->setValue('y', '512');

		Assert::equal(['a' => '1', 'b' => '2', 'x' => '256', 'y' => '512'], $config->getValues());

		Assert::same('256', $config->getValue('x'));
		Assert::same('unknown', $config->getValue('myValue', 'unknown'));

		Assert::same('a=1&b=2&x=256&y=512', $config->getSerialized());
	}
}

(new DynamicConfigurationTest)->run();
