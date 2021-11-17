<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Client;

use MagicLegacy\Component\Search\Entity\CardAtomic;
use MagicLegacy\Component\Search\Exception\SearchClientException;
use MagicLegacy\Component\Search\Formatter\CardAtomicFormatter;

/**
 * Class AtomicClient
 *
 * @author Romain Cottard
 */
class SearchClient extends AbstractClient
{
    /**
     * @param string $query
     * @return CardAtomic[]
     * @throws SearchClientException
     */
    public function searchAtomicCards(string $query): iterable
    {
        $result = $this->fetchResult('/atomic/_search?q=' . urlencode($query) . '&default_operator=AND', new CardAtomicFormatter());

        if (empty($result)) {
            $result = [];
        }

        return $result;
    }
}
