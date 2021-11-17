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
 * Class ForeignData
 *
 * @author Romain Cottard
 */
final class ForeignData implements \JsonSerializable
{
    use SearchSerializableTrait;

    private string $faceName;
    private string $name;
    private string $text;
    private string $flavorText;
    private string $language;
    private int $multiverseId;
    private string $type;

    /**
     * ForeignData constructor.
     *
     * @param string $faceName
     * @param string $name
     * @param string $text
     * @param string $flavorText
     * @param string $language
     * @param int $multiverseId
     * @param string $type
     */
    public function __construct(
        string $faceName,
        string $name,
        string $text,
        string $flavorText,
        string $language,
        int $multiverseId,
        string $type
    ) {
        $this->faceName     = $faceName;
        $this->name         = $name;
        $this->text         = $text;
        $this->flavorText   = $flavorText;
        $this->language     = $language;
        $this->multiverseId = $multiverseId;
        $this->type         = $type;
    }

    /**
     * @return string
     */
    public function getFaceName(): string
    {
        return $this->faceName;
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
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getFlavorText(): string
    {
        return $this->flavorText;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return int
     */
    public function getMultiverseId(): int
    {
        return $this->multiverseId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
