<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Formatter;

use MagicLegacy\Component\Search\Entity\CardAtomic;

/**
 * Class CardAtomicFormatter
 *
 * @author Romain Cottard
 */
final class CardAtomicFormatter implements FormatterInterface
{
    /**
     * Format data & return list of value object.
     *
     * @param mixed $data
     * @return CardAtomic[]
     */
    public function format($data)
    {
        $cards = [];
        if (empty($data->hits->hits) || $data->hits->total->value === 0) {
            return [];
        }

        foreach ($data->hits->hits as $result) {
            $card = $result->_source; // first element

            //~ Sub entities
            $leadershipSkills = (new LeadershipSkillsFormatter())->format($card->leadership_skills);
            $legalities       = (new LegalitiesFormatter())->format($card->legalities);
            $foreignData      = (new ForeignDataFormatter())->format($card->foreign_data);
            $identifiers      = (new IdentifiersFormatter())->format($card->identifiers);
            $rulings          = (new RulingsFormatter())->format($card->rulings);

            //~ Format card data
            $cards[] = new CardAtomic(
                (int) $card->id,
                (string) $card->side,
                //~ Names & side
                (string) $card->name,
                (string) $card->name_face,
                (string) $card->name_ascii,
                //~ Layout design
                (string) $card->layout,
                //~ Cost
                (string) $card->mana_cost,
                (float) $card->converted_cost,
                (float) $card->converted_cost_face,
                //~ Color
                (array) $card->colors,
                (array) $card->colors_identity,
                (array) $card->colors_indicator,
                //~ Types
                (string) $card->type,
                (array) $card->super_types,
                (array) $card->types,
                (array) $card->sub_types,
                //~ Card properties
                (array) $card->keywords,
                (string) $card->text,
                //~ Translations
                $rulings,
                $foreignData,
                (string) $card->power,
                (string) $card->toughness,
                (string) $card->loyalty,
                //~ Modifiers
                (string) $card->hand_modifier,
                (string) $card->life_modifier,
                (bool) $card->has_alternative_deck_limit,
                (bool) $card->is_reserved,
                //~ Legalities & printings
                (array) $card->printings,
                $legalities,
                //~ commander
                $leadershipSkills,
                (int) $card->edh_rec_rank,
                //~ Misc
                $identifiers,
            );
        }

        return $cards;
    }
}
