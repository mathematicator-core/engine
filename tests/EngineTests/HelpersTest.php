<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\Engine\Helpers;
use Nette\Utils\ArrayHash;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class HelpersTest extends TestCase
{

	public function testCreateInstance(): void
	{
		Assert::exception(function () {
			new Helpers;
		}, \Error::class);
	}


	public function testGetCurrentUrl(): void
	{
		$_SERVER['REQUEST_URI'] = 'kontakt';
		$_SERVER['HTTP_HOST'] = 'baraja.cz';
		$_SERVER['HTTPS'] = 'on';

		Assert::same('https://baraja.cz/kontakt', Helpers::getCurrentUrl());
	}


	public function testGetBaseUrl(): void
	{
		$_SERVER['REQUEST_URI'] = 'kontakt';
		$_SERVER['HTTP_HOST'] = 'baraja.cz';
		$_SERVER['HTTPS'] = 'on';

		Assert::same('https://baraja.cz', Helpers::getBaseUrl());
	}


	/**
	 * @dataprovider getStrictScalarTypes
	 * @param mixed $expected
	 * @param mixed $haystack
	 * @param bool $rewriteObjectsToString
	 */
	public function testStrictScalarType($expected, $haystack, bool $rewriteObjectsToString): void
	{
		Assert::equal($expected, Helpers::strictScalarType($haystack, $rewriteObjectsToString));
	}


	/**
	 * @return mixed[][]
	 */
	public function getStrictScalarTypes(): array
	{
		return [
			[1, 1, false],
			[1, 1, true],
			['Baraja', 'Baraja', false],
			[['key' => 'value'], ArrayHash::from(['key' => 'value']), true],
			[['key' => 'value'], ArrayHash::from(['key' => 'value']), false],
		];
	}
}

(new HelpersTest)->run();
