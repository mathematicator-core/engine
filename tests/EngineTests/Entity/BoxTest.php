<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Tests;


use Mathematicator\Engine\Box;
use Nette\Utils\Json;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

class BoxTest extends TestCase
{

	public function testSimpleText(): void
	{
		$box = new Box(Box::TYPE_TEXT, 'Result', 'Result does not exist.');

		Assert::same(Box::TYPE_TEXT, $box->getType());
		Assert::same('Result', $box->getTitle());
		Assert::same('Result does not exist.', $box->getText());
	}


	public function testSimpleTextToString(): void
	{
		$box = new Box(Box::TYPE_TEXT, 'Result', 'Result does not exist.');

		Assert::same('Result does not exist.', (string) $box);
	}


	public function testIcon(): void
	{
		// No icon
		$boxText = new Box(Box::TYPE_TEXT);
		Assert::same('<i class="fas fa-hashtag"></i>', $boxText->getIcon());


		// No icon but image
		$boxImage = new Box(Box::TYPE_IMAGE);
		Assert::same('<i class="fas fa-image"></i>', $boxImage->getIcon());


		$boxCustomIcon = new Box(Box::TYPE_TEXT);
		$boxCustomIcon->setIcon('fas fa-abcd');
		Assert::same('<i class="fas fa-abcd"></i>', $boxCustomIcon->getIcon());


		Assert::exception(function () {
			$boxInvalidCustomIcon = new Box(Box::TYPE_TEXT);
			$boxInvalidCustomIcon->setIcon('invalid icon name');
		}, \RuntimeException::class);
	}


	public function testTable(): void
	{
		$table = [
			['One', 'Two', 'Three'],
			[1, 2, 3],
		];

		$box = new Box(Box::TYPE_TABLE, 'Result');
		$box->setTable($table);

		Assert::same(Json::encode($table), $box->getText());
	}


	public function testTableToString(): void
	{
		$box = new Box(Box::TYPE_TABLE, 'Result');

		Assert::same('', (string) $box);
	}


	public function testTag(): void
	{
		$box = new Box(Box::TYPE_TEXT, 'No result');
		$box->setTag('no-results');

		Assert::same('no-results', $box->getTag());
	}


	public function testRank(): void
	{
		$box = new Box(Box::TYPE_TEXT);

		$box->setRank(25);
		Assert::same(25, $box->getRank());

		$box->setRank(150);
		Assert::same(100, $box->getRank());

		$box->setRank(-1);
		Assert::same(0, $box->getRank());
	}
}

(new BoxTest)->run();
