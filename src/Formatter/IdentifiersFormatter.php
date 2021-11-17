<?php

/*
 *  Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Formatter;

use MagicLegacy\Component\Search\Entity\Identifiers;

/**
 * Class IdentifiersFormatter
 *
 * @author Romain Cottard
 */
final class IdentifiersFormatter implements FormatterInterface
{
    /**
     * Format data & return list of value object.
     *
     * @param mixed $data
     * @return Identifiers
     */
    public function format($data)
    {
        return new Identifiers(
            $data->cardKingdomFoilId ?? '',
            $data->cardKingdomId ?? '',
            $data->mcmId ?? '',
            $data->mcmMetaId ?? '',
            $data->mtgArenaId ?? '',
            $data->mtgoFoilId ?? '',
            $data->mtgoId ?? '',
            $data->mtgjsonV4Id ?? '',
            $data->multiverseId ?? '',
            $data->scryfallId ?? '',
            $data->scryfallOracleId ?? '',
            $data->scryfallIllustrationId ?? '',
            $data->tcgplayerProductId ?? ''
        );
    }
}
