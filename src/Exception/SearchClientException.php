<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Exception;

use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class SearchClientException
 *
 * @author Romain Cottard
 */
class SearchClientException extends SearchComponentException implements ClientExceptionInterface
{
}
