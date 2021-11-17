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
 * Class Identifiers
 *
 * @author Romain Cottard
 */
final class Identifiers implements \JsonSerializable
{
    use SearchSerializableTrait;

    private string $cardKingdomFoilId;
    private string $cardKingdomId;
    private string $mcmId;
    private string $mcmMetaId;
    private string $mtgArenaId;
    private string $mtgoFoilId;
    private string $mtgoId;
    private string $mtgjsonV4Id;
    private string $multiverseId;
    private string $scryfallId;
    private string $scryfallOracleId;
    private string $scryfallIllustrationId;
    private string $tcgplayerProductId;

    /**
     * Identifiers constructor.
     *
     * @param string $cardKingdomFoilId
     * @param string $cardKingdomId
     * @param string $mcmId
     * @param string $mcmMetaId
     * @param string $mtgArenaId
     * @param string $mtgoFoilId
     * @param string $mtgoId
     * @param string $mtgjsonV4Id
     * @param string $multiverseId
     * @param string $scryfallId
     * @param string $scryfallOracleId
     * @param string $scryfallIllustrationId
     * @param string $tcgplayerProductId
     */
    public function __construct(
        string $cardKingdomFoilId,
        string $cardKingdomId,
        string $mcmId,
        string $mcmMetaId,
        string $mtgArenaId,
        string $mtgoFoilId,
        string $mtgoId,
        string $mtgjsonV4Id,
        string $multiverseId,
        string $scryfallId,
        string $scryfallOracleId,
        string $scryfallIllustrationId,
        string $tcgplayerProductId
    ) {
        $this->cardKingdomFoilId      = $cardKingdomFoilId;
        $this->cardKingdomId          = $cardKingdomId;
        $this->mcmId                  = $mcmId;
        $this->mcmMetaId              = $mcmMetaId;
        $this->mtgArenaId             = $mtgArenaId;
        $this->mtgoFoilId             = $mtgoFoilId;
        $this->mtgoId                 = $mtgoId;
        $this->mtgjsonV4Id            = $mtgjsonV4Id;
        $this->multiverseId           = $multiverseId;
        $this->scryfallId             = $scryfallId;
        $this->scryfallOracleId       = $scryfallOracleId;
        $this->scryfallIllustrationId = $scryfallIllustrationId;
        $this->tcgplayerProductId     = $tcgplayerProductId;
    }

    /**
     * @return string
     */
    public function getCardKingdomFoilId(): string
    {
        return $this->cardKingdomFoilId;
    }

    /**
     * @return string
     */
    public function getCardKingdomId(): string
    {
        return $this->cardKingdomId;
    }

    /**
     * @return string
     */
    public function getMcmId(): string
    {
        return $this->mcmId;
    }

    /**
     * @return string
     */
    public function getMcmMetaId(): string
    {
        return $this->mcmMetaId;
    }

    /**
     * @return string
     */
    public function getMtgArenaId(): string
    {
        return $this->mtgArenaId;
    }

    /**
     * @return string
     */
    public function getMtgoFoilId(): string
    {
        return $this->mtgoFoilId;
    }

    /**
     * @return string
     */
    public function getMtgoId(): string
    {
        return $this->mtgoId;
    }

    /**
     * @return string
     */
    public function getMtgjsonV4Id(): string
    {
        return $this->mtgjsonV4Id;
    }

    /**
     * @return string
     */
    public function getMultiverseId(): string
    {
        return $this->multiverseId;
    }

    /**
     * @return string
     */
    public function getScryfallId(): string
    {
        return $this->scryfallId;
    }

    /**
     * @return string
     */
    public function getScryfallOracleId(): string
    {
        return $this->scryfallOracleId;
    }

    /**
     * @return string
     */
    public function getScryfallIllustrationId(): string
    {
        return $this->scryfallIllustrationId;
    }

    /**
     * @return string
     */
    public function getTcgplayerProductId(): string
    {
        return $this->tcgplayerProductId;
    }
}
