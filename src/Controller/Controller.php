<?php

declare(strict_types=1);

namespace Mathematicator\Engine\Controller;


use Baraja\Service;
use Mathematicator\Engine\Entity\Context;
use Mathematicator\Engine\Entity\Query;
use Mathematicator\Engine\Exception\InvalidDataException;

interface Controller extends Service
{
	/**
	 * @throws InvalidDataException
	 */
	public function createContext(Query $query): Context;

	public function getContext(): Context;
}
