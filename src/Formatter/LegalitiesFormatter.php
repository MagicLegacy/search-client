<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Formatter;

use MagicLegacy\Component\Search\Entity\Legalities;
use MagicLegacy\Component\Search\Enumerator\LegalityEnumerator;

/**
 * Class LegalitiesFormatter
 *
 * @author Romain Cottard
 */
final class LegalitiesFormatter implements FormatterInterface
{
    /**
     * Format data & return list of value object.
     *
     * @param mixed $data
     * @return Legalities
     */
    public function format($data)
    {
        if (empty($data)) {
            return new Legalities();
        }

        return new Legalities(
            $data->brawl ?? LegalityEnumerator::NOT_LEGAL,
            $data->commander ?? LegalityEnumerator::NOT_LEGAL,
            $data->duel ?? LegalityEnumerator::NOT_LEGAL,
            $data->future ?? LegalityEnumerator::NOT_LEGAL,
            $data->frontier ?? LegalityEnumerator::NOT_LEGAL,
            $data->legacy ?? LegalityEnumerator::NOT_LEGAL,
            $data->modern ?? LegalityEnumerator::NOT_LEGAL,
            $data->pauper ?? LegalityEnumerator::NOT_LEGAL,
            $data->penny ?? LegalityEnumerator::NOT_LEGAL,
            $data->pioneer ?? LegalityEnumerator::NOT_LEGAL,
            $data->standard ?? LegalityEnumerator::NOT_LEGAL,
            $data->vintage ?? LegalityEnumerator::NOT_LEGAL
        );
    }
}
