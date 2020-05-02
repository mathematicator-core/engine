<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests\Helper;


use Mathematicator\Engine\Helper\DateTime;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

class DateTimeTest extends TestCase
{

	/**
	 * @dataprovider getDateTimeIsoTestCases
	 * @param string $expected
	 * @param int $input
	 */
	public function testGetDateTimeIso(string $expected, int $input): void
	{
		Assert::same($expected, DateTime::getDateTimeIso($input));
	}


	/**
	 * @dataprovider getFormatTimeAgoTestCases
	 * @param string $expected
	 * @param array $input
	 */
	public function testFormatTimeAgo(string $expected, array $input): void
	{
		Assert::same($expected, DateTime::formatTimeAgo($input[0], $input[1], $input[2], $input[3]));
	}


	/**
	 * @return string[]
	 */
	public function getDateTimeIsoTestCases(): array
	{
		return [
			['2020-12-25 20:12:03', (int) (new \DateTime('2020-12-25 20:12:03'))->format('U')],
		];
	}


	/**
	 * @return string[]
	 */
	public function getFormatTimeAgoTestCases(): array
	{
		return [
			['1 měsíc', [(int) (new \DateTime('2019-12-25 20:12:03'))->format('U'), false, 'cz', (int) (new \DateTime('2020-01-25 20:12:03'))->format('U')]],
			['2 months', [(int) (new \DateTime('2019-12-25 20:12:03'))->format('U'), false, 'en', (int) (new \DateTime('2020-02-25 20:12:03'))->format('U')]],
		];
	}
}

(new DateTimeTest())->run();
