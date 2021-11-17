<?php

/*
 *  Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Formatter;

use MagicLegacy\Component\Search\Entity\Ruling;

/**
 * Class RulingsFormatter
 *
 * @author Romain Cottard
 */
final class RulingsFormatter implements FormatterInterface
{
    /**
     * Format data & return list of value object.
     *
     * @param mixed $data
     * @return Ruling[]
     */
    public function format($data)
    {
        if (empty($data)) {
            return [];
        }

        $rulings = [];
        foreach ($data as $ruling) {
            $rulings[] = new Ruling(
                $ruling->date,
                $ruling->text,
            );
        }

        return $rulings;
    }
}
