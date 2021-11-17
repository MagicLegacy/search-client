<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Serializer;

use MagicLegacy\Component\Search\Exception\SearchSerializerException;

/**
 * Interface JsonSerializerInterface
 *
 * @author Romain Cottard
 */
interface SearchSerializerInterface extends \JsonSerializable
{
    /**
     * @param \JsonSerializable $object
     * @return string
     * @throws SearchSerializerException
     */
    public function serialize(\JsonSerializable $object): string;

    /**
     * @param string $json
     * @return SearchSerializerInterface
     * @throws SearchSerializerException
     */
    public static function deserialize(string $json): SearchSerializerInterface;
}
