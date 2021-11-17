<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Entity;

use MagicLegacy\Component\Search\Serializer\SearchSerializableTrait;

/**
 * Class Card
 *
 * @author Romain Cottard
 */
final class CardAtomic implements \JsonSerializable
{
    use SearchSerializableTrait;

    private int $id;
    private string $side;
    private string $name;
    private string $nameFace;
    private string $nameAscii;
    private string $layout;
    private string $manaCost;
    private float $convertedCost;
    private float $convertedCostFace;
    private string $text;
    private string $type;
    private string $power;
    private string $toughness;
    private string $loyalty;
    private string $handModifier;
    private string $lifeModifier;
    private bool $hasAlternativeDeckLimit;
    private bool $isReserved;
    private int $edhrecRank;

    private LeadershipSkills $leadershipSkills;
    private Legalities $legalities;
    private Identifiers $identifiers;

    /** @var string[] $colors */
    private array $colors;

    /** @var string[] $colorIdentity */
    private array $colorIdentity;

    /** @var string[] $colorIndicator */
    private array $colorIndicator;

    /** @var string[] $keywords */
    private array $keywords;

    /** @var string[] $subTypes */
    private array $subTypes;

    /** @var string[] $superTypes */
    private array $superTypes;

    /** @var string[] $types */
    private array $types;

    /** @var Ruling[] $rulings */
    private array $rulings;

    /** @var ForeignData[] $foreignData */
    private array $foreignData;

    /** @var string[] $printings Set code of printed version*/
    private array $printings;

    /**
     * Class constructor.
     *
     * @param int $id
     * @param string $side
     * @param string $nameFace
     * @param string $name
     * @param string $nameAscii
     * @param string $layout
     * @param string $manaCost
     * @param float $convertedCost
     * @param float $convertedCostFace
     * @param string[] $colors
     * @param string[] $colorIdentity
     * @param string[] $colorIndicator
     * @param string $type
     * @param string[] $superTypes
     * @param string[] $types
     * @param string[] $subTypes
     * @param string[] $keywords
     * @param string $text
     * @param Ruling[] $rulings
     * @param ForeignData[] $foreignData
     * @param string $power
     * @param string $toughness
     * @param string $loyalty
     * @param string $handModifier
     * @param string $lifeModifier
     * @param bool $hasAlternativeDeckLimit
     * @param bool $isReserved
     * @param string[] $printings
     * @param Legalities $legalities
     * @param LeadershipSkills $leadershipSkills
     * @param int $edhrecRank
     * @param Identifiers $identifiers
     */
    public function __construct(
        int $id,
        string $side,
        string $name,
        string $nameFace,
        string $nameAscii,
        string $layout,
        string $manaCost,
        float $convertedCost,
        float $convertedCostFace,
        array $colors,
        array $colorIdentity,
        array $colorIndicator,
        string $type,
        array $superTypes,
        array $types,
        array $subTypes,
        array $keywords,
        string $text,
        iterable $rulings,
        array $foreignData,
        string $power,
        string $toughness,
        string $loyalty,
        string $handModifier,
        string $lifeModifier,
        bool $hasAlternativeDeckLimit,
        bool $isReserved,
        array $printings,
        Legalities $legalities,
        LeadershipSkills $leadershipSkills,
        int $edhrecRank,
        Identifiers $identifiers
    ) {
        $this->id                      = $id;
        $this->side                    = $side;
        $this->name                    = $name;
        $this->nameFace                = $nameFace;
        $this->nameAscii               = $nameAscii;
        $this->manaCost                = $manaCost;
        $this->layout                  = $layout;
        $this->convertedCost           = $convertedCost;
        $this->convertedCostFace       = $convertedCostFace;
        $this->colorIdentity           = $colorIdentity;
        $this->colorIndicator          = $colorIndicator;
        $this->colors                  = $colors;
        $this->type                    = $type;
        $this->superTypes              = $superTypes;
        $this->types                   = $types;
        $this->subTypes                = $subTypes;
        $this->keywords                = $keywords;
        $this->text                    = $text;
        $this->rulings                 = $rulings;
        $this->foreignData             = $foreignData;
        $this->power                   = $power;
        $this->toughness               = $toughness;
        $this->loyalty                 = $loyalty;
        $this->handModifier            = $handModifier;
        $this->lifeModifier            = $lifeModifier;
        $this->hasAlternativeDeckLimit = $hasAlternativeDeckLimit;
        $this->isReserved              = $isReserved;
        $this->printings               = $printings;
        $this->legalities              = $legalities;
        $this->leadershipSkills        = $leadershipSkills;
        $this->edhrecRank              = $edhrecRank;
        $this->identifiers             = $identifiers;
    }

    /**
     * @return Ruling[]
     */
    public function getRulings(): array
    {
        return $this->rulings;
    }

    /**
     * @return string
     */
    public function getManaCost(): string
    {
        return $this->manaCost;
    }

    /**
     * @return float
     */
    public function getConvertedCost(): float
    {
        return $this->convertedCost;
    }

    /**
     * @return float
     */
    public function getConvertedCostFace(): float
    {
        return $this->convertedCostFace;
    }

    /**
     * @return string
     */
    public function getSide(): string
    {
        return $this->side;
    }

    /**
     * @return string
     */
    public function getNameFace(): string
    {
        return $this->nameFace;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNameAscii(): string
    {
        return $this->nameAscii;
    }

    /**
     * @return array
     */
    public function getColorIdentity(): array
    {
        return $this->colorIdentity;
    }

    /**
     * @return array
     */
    public function getColorIndicator(): array
    {
        return $this->colorIndicator;
    }

    /**
     * @return array
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @return array
     */
    public function getSubTypes(): array
    {
        return $this->subTypes;
    }

    /**
     * @return array
     */
    public function getSupertypes(): array
    {
        return $this->superTypes;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @return string[]
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getLoyalty(): string
    {
        return $this->loyalty;
    }

    /**
     * @return string
     */
    public function getPower(): string
    {
        return $this->power;
    }

    /**
     * @return string
     */
    public function getToughness(): string
    {
        return $this->toughness;
    }

    /**
     * @return string
     */
    public function getHandModifier(): string
    {
        return $this->handModifier;
    }

    /**
     * @return string
     */
    public function getLifeModifier(): string
    {
        return $this->lifeModifier;
    }

    /**
     * @return bool
     */
    public function hasAlternativeDeckLimit(): bool
    {
        return $this->hasAlternativeDeckLimit;
    }

    /**
     * @return LeadershipSkills
     */
    public function getLeadershipSkills(): LeadershipSkills
    {
        return $this->leadershipSkills;
    }

    /**
     * @return Legalities
     */
    public function getLegalities(): Legalities
    {
        return $this->legalities;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @return ForeignData[]
     */
    public function getAllForeignData(): iterable
    {
        return $this->foreignData;
    }

    /**
     * @param string $language
     * @return ForeignData
     */
    public function getForeignData(string $language): ForeignData
    {
        return $this->foreignData[$language] ?? new ForeignData('', '', '', '', '', 0, '');
    }

    /**
     * @return array
     */
    public function getPrintings(): array
    {
        return $this->printings;
    }
    /**
     * @return bool
     */
    public function isReserved(): bool
    {
        return $this->isReserved;
    }

    /**
     * @return int
     */
    public function getEdhrecRank(): int
    {
        return $this->edhrecRank;
    }

    /**
     * @return Identifiers
     */
    public function getIdentifiers(): Identifiers
    {
        return $this->identifiers;
    }
}
