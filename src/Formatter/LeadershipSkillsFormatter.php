<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Formatter;

use MagicLegacy\Component\Search\Entity\LeadershipSkills;

/**
 * Class LeadershipSkillsFormatter
 *
 * @author Romain Cottard
 */
final class LeadershipSkillsFormatter implements FormatterInterface
{
    /**
     * Format data & return list of value object.
     *
     * @param mixed $data
     * @return LeadershipSkills|null
     */
    public function format($data)
    {
        if (empty($data)) {
            return new LeadershipSkills();
        }

        return new LeadershipSkills(
            (bool) ($data->brawl ?? false),
            (bool) ($data->commander ?? false),
            (bool) ($data->oathbreaker ?? false)
        );
    }
}
