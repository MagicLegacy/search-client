<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Tests\Formatter;

use MagicLegacy\Component\Search\Entity\Identifiers;
use MagicLegacy\Component\Search\Entity\LeadershipSkills;
use MagicLegacy\Component\Search\Entity\Legalities;
use MagicLegacy\Component\Search\Enumerator\LegalityEnumerator;
use MagicLegacy\Component\Search\Formatter\CardAtomicFormatter;
use PHPUnit\Framework\TestCase;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;

/**
 * Class CardAtomicFormatterTest
 */
class CardAtomicFormatterTest extends TestCase
{
    /**
     * @return void
     * @throws JsonException
     */
    public function testICanGetValuesFromValueObjectAfterFormatting(): void
    {
        $result   = $this->getResponseObject();
        $cards    = (array) $result->hits->hits;
        $entities = (new CardAtomicFormatter())->format($this->getResponseObject());

        $entity = reset($entities);
        $data   = reset($cards);
        $data   = $data->_source; // first element

        $this->assertEquals($data->name, $entity->getName());

        $this->assertEquals([''], $entity->getColorIndicator());
        $this->assertEquals($data->colors, $entity->getColors());
        $this->assertEquals($data->colors_identity, $entity->getColorIdentity());

        $this->assertEquals($data->mana_cost, $entity->getManaCost());
        $this->assertEquals($data->converted_cost, $entity->getConvertedCost());

        $this->assertEquals($data->layout, $entity->getLayout());
        $this->assertEquals($data->printings, $entity->getPrintings());
        $this->assertEquals($data->keywords, $entity->getKeywords());
        $this->assertEquals($data->text, $entity->getText());
        $this->assertEquals($data->type, $entity->getType());
        $this->assertEquals($data->types, $entity->getTypes());

        $this->assertIsArray($entity->getAllForeignData());
        $this->assertCount(6, $entity->getAllForeignData());
        $foreignDataFr = $entity->getForeignData('French');
        $this->assertEquals($data->foreign_data->French->language, $foreignDataFr->getLanguage());
        $this->assertEquals($data->foreign_data->French->name, $foreignDataFr->getName());
        $this->assertEquals($data->foreign_data->French->type, $foreignDataFr->getType());
        $this->assertEquals($data->foreign_data->French->text, $foreignDataFr->getText());
        $this->assertEquals($data->foreign_data->French->flavorText, $foreignDataFr->getFlavorText());
        $this->assertEquals('', $foreignDataFr->getFaceName());
        $this->assertEquals(0, $foreignDataFr->getMultiverseId());


        $identifiers = $entity->getIdentifiers();
        $this->assertInstanceOf(Identifiers::class, $identifiers);
        $this->assertEquals($data->identifiers->cardKingdomFoilId ?? '', $identifiers->getCardKingdomFoilId());
        $this->assertEquals($data->identifiers->cardKingdomId ?? '', $identifiers->getCardKingdomId());
        $this->assertEquals($data->identifiers->mcmId ?? '', $identifiers->getMcmId());
        $this->assertEquals($data->identifiers->mcmMetaId ?? '', $identifiers->getMcmMetaId());
        $this->assertEquals($data->identifiers->mtgArenaId ?? '', $identifiers->getMtgArenaId());
        $this->assertEquals($data->identifiers->mtgoFoilId ?? '', $identifiers->getMtgoFoilId());
        $this->assertEquals($data->identifiers->mtgoId ?? '', $identifiers->getMtgoId());
        $this->assertEquals($data->identifiers->mtgjsonV4Id ?? '', $identifiers->getMtgjsonV4Id());
        $this->assertEquals($data->identifiers->multiverseId ?? '', $identifiers->getMultiverseId());
        $this->assertEquals($data->identifiers->scryfallId ?? '', $identifiers->getScryfallId());
        $this->assertEquals($data->identifiers->scryfallOracleId ?? '', $identifiers->getScryfallOracleId());
        $this->assertEquals($data->identifiers->scryfallIllustrationId ?? '', $identifiers->getScryfallIllustrationId());
        $this->assertEquals($data->identifiers->tcgplayerProductId ?? '', $identifiers->getTcgplayerProductId());

        $legalities = $entity->getLegalities();
        $this->assertInstanceOf(Legalities::class, $legalities);
        $this->assertEquals($data->legalities->brawl ?? LegalityEnumerator::NOT_LEGAL, $legalities->getBrawl());
        $this->assertEquals($data->legalities->commander ?? LegalityEnumerator::NOT_LEGAL, $legalities->getCommander());
        $this->assertEquals($data->legalities->duel ?? LegalityEnumerator::NOT_LEGAL, $legalities->getDuel());
        $this->assertEquals($data->legalities->future ?? LegalityEnumerator::NOT_LEGAL, $legalities->getFuture());
        $this->assertEquals($data->legalities->frontier ?? LegalityEnumerator::NOT_LEGAL, $legalities->getFrontier());
        $this->assertEquals($data->legalities->legacy ?? LegalityEnumerator::NOT_LEGAL, $legalities->getLegacy());
        $this->assertEquals($data->legalities->modern ?? LegalityEnumerator::NOT_LEGAL, $legalities->getModern());
        $this->assertEquals($data->legalities->pauper ?? LegalityEnumerator::NOT_LEGAL, $legalities->getPauper());
        $this->assertEquals($data->legalities->penny ?? LegalityEnumerator::NOT_LEGAL, $legalities->getPenny());
        $this->assertEquals($data->legalities->pioneer ?? LegalityEnumerator::NOT_LEGAL, $legalities->getPioneer());
        $this->assertEquals($data->legalities->standard ?? LegalityEnumerator::NOT_LEGAL, $legalities->getStandard());
        $this->assertEquals($data->legalities->vintage ?? LegalityEnumerator::NOT_LEGAL, $legalities->getVintage());

        $rulings = $entity->getRulings();
        $this->assertIsArray($rulings);
        $this->assertCount(0, $rulings);

        $this->assertIsArray($entity->getSubTypes());
        $this->assertCount(2, $entity->getSubTypes());

        $this->assertIsArray($entity->getSuperTypes());
        $this->assertCount(1, $entity->getSuperTypes());

        $this->assertEquals($data->converted_cost_face ?? 0.0, $entity->getConvertedCostFace());
        $this->assertEquals($data->side ?? '', $entity->getSide());
        $this->assertEquals($data->name_face ?? '', $entity->getNameFace());
        $this->assertEquals($data->name_ascii ?? '', $entity->getNameAscii());
        $this->assertEquals($data->loyalty ?? '', $entity->getLoyalty());
        $this->assertEquals($data->power ?? '', $entity->getPower());
        $this->assertEquals($data->toughness ?? '', $entity->getToughness());
        $this->assertEquals($data->hand_modifier ?? '', $entity->getHandModifier());
        $this->assertEquals($data->life_modifier ?? '', $entity->getLifeModifier());
        $this->assertEquals($data->has_alternative_deck_limit ?? false, $entity->hasAlternativeDeckLimit());
        $this->assertEquals($data->is_reserved ?? false, $entity->isReserved());
        $this->assertEquals($data->edh_rec_rank ?? 0, $entity->getEdhrecRank());

        $leadershipSkills = $entity->getLeadershipSkills();
        $this->assertInstanceOf(LeadershipSkills::class, $entity->getLeadershipSkills());
        $this->assertFalse($leadershipSkills->hasBrawl());
        $this->assertFalse($leadershipSkills->hasCommander());
        $this->assertFalse($leadershipSkills->hasOathbreaker());
    }

    /**
     * @return \stdClass
     * @throws JsonException
     */
    private function getResponseObject(): \stdClass
    {
        $response = <<<'RESPONSE'
{
  "took": 6,
  "timed_out": false,
  "_shards": {
    "total": 1,
    "successful": 1,
    "skipped": 0,
    "failed": 0
  },
  "hits": {
    "total": {
      "value": 2,
      "relation": "eq"
    },
    "max_score": 8.954285,
    "hits": [
      {
        "_index": "atomic",
        "_type": "_doc",
        "_id": "11560",
        "_score": 8.954285,
        "_source": {
          "id": 11560,
          "side": "a",
          "name": "Llanowar Cavalry",
          "name_face": "",
          "name_ascii": "",
          "layout": "normal",
          "mana_cost": "{2}{G}",
          "converted_cost": 3,
          "converted_cost_face": 0,
          "colors": [
            "G"
          ],
          "colors_identity": [
            "G",
            "W"
          ],
          "colors_indicator": [
            ""
          ],
          "type": "Creature — Human Soldier",
          "super_types": [
            ""
          ],
          "types": [
            "Creature"
          ],
          "sub_types": [
            "Human",
            "Soldier"
          ],
          "keywords": [
            ""
          ],
          "text": "{W}: Llanowar Cavalry gains vigilance until end of turn.",
          "rulings": [],
          "foreign_data": {
            "German": {
              "faceName": "",
              "name": "Llanowar-Reiterei",
              "text": "{W}: Die Llanowar-Reiterei wird beim Angreifen nicht getappt.",
              "flavorText": "Zum ersten Mal wurden die Benalischen Soldaten von den Llanowarelfen mit etwas anderem als Pfeilen empfangen.",
              "language": "German",
              "multiverseId": 0,
              "type": "Kreatur — Soldat"
            },
            "Spanish": {
              "faceName": "",
              "name": "Caballería de Llanowar",
              "text": "",
              "flavorText": "",
              "language": "Spanish",
              "multiverseId": 0,
              "type": ""
            },
            "French": {
              "faceName": "",
              "name": "Cavalerie de Llanowar",
              "text": "{W}: Attaquer avec la Cavalerie de Llanowar ne la fait pas s'engager ce tour-ci.",
              "flavorText": "Pour la première fois, les elfes accueillirent les soldats bénalians dans la forêt avec autre chose qu'un déluge de flèches.",
              "language": "French",
              "multiverseId": 0,
              "type": "Créature : soldat"
            },
            "Italian": {
              "faceName": "",
              "name": "Cavalleria di Llanowar",
              "text": "",
              "flavorText": "",
              "language": "Italian",
              "multiverseId": 0,
              "type": ""
            },
            "Japanese": {
              "faceName": "",
              "name": "ラノワールの騎兵隊",
              "text": "",
              "flavorText": "",
              "language": "Japanese",
              "multiverseId": 0,
              "type": ""
            },
            "Portuguese (Brazil)": {
              "faceName": "",
              "name": "Cavalaria de Llanowar",
              "text": "",
              "flavorText": "",
              "language": "Portuguese (Brazil)",
              "multiverseId": 0,
              "type": ""
            }
          },
          "power": "1",
          "toughness": "4",
          "loyalty": "",
          "hand_modifier": "",
          "life_modifier": "",
          "has_alternative_deck_limit": false,
          "is_reserved": false,
          "printings": [
            "INV"
          ],
          "legalities": {
            "brawl": "Not Legal",
            "commander": "Legal",
            "duel": "Legal",
            "future": "Not Legal",
            "frontier": "Not Legal",
            "legacy": "Legal",
            "modern": "Not Legal",
            "pauper": "Legal",
            "penny": "Legal",
            "pioneer": "Not Legal",
            "standard": "Not Legal",
            "vintage": "Legal"
          },
          "leadership_skills": {
            "hasBrawl": false,
            "hasCommander": false,
            "hasOathbreaker": false
          },
          "edh_rec_rank": 21826,
          "identifiers": {
            "cardKingdomFoilId": "",
            "cardKingdomId": "",
            "mcmId": "",
            "mcmMetaId": "",
            "mtgArenaId": "",
            "mtgoFoilId": "",
            "mtgoId": "",
            "mtgjsonV4Id": "",
            "multiverseId": "",
            "scryfallId": "",
            "scryfallOracleId": "3e6e70eb-6638-4aa6-997b-90f5810e12a0",
            "scryfallIllustrationId": "",
            "tcgplayerProductId": ""
          }
        }
      },
      {
        "_index": "atomic",
        "_type": "_doc",
        "_id": "11561",
        "_score": 8.954285,
        "_source": {
          "id": 11561,
          "side": "a",
          "name": "Llanowar Dead",
          "name_face": "",
          "name_ascii": "",
          "layout": "normal",
          "mana_cost": "{B}{G}",
          "converted_cost": 2,
          "converted_cost_face": 0,
          "colors": [
            "B",
            "G"
          ],
          "colors_identity": [
            "B",
            "G"
          ],
          "colors_indicator": [
            ""
          ],
          "type": "Creature — Zombie Elf",
          "super_types": [
            ""
          ],
          "types": [
            "Creature"
          ],
          "sub_types": [
            "Zombie",
            "Elf"
          ],
          "keywords": [
            ""
          ],
          "text": "{T}: Add {B}.",
          "rulings": [],
          "foreign_data": {
            "German": {
              "faceName": "",
              "name": "Llanowar-Leichen",
              "text": "{T}: Erhöhe deinen Manavorrat um {B}.",
              "flavorText": "Wie die Blätter von den Ästen der Bäume im Herbst abfallen, verlassen auch die toten Elfen Elfheim.",
              "language": "German",
              "multiverseId": 0,
              "type": "Kreatur — Zombie, Elf"
            },
            "Spanish": {
              "faceName": "",
              "name": "Muerta de Llanowar",
              "text": "",
              "flavorText": "",
              "language": "Spanish",
              "multiverseId": 0,
              "type": ""
            },
            "French": {
              "faceName": "",
              "name": "Morts de Llanowar",
              "text": "{T} : Ajoutez {B} à votre réserve.",
              "flavorText": "Tout comme les feuilles quittent les branches des arbres, les morts quittèrent leur terrelfe.",
              "language": "French",
              "multiverseId": 0,
              "type": "Créature : zombie et elfe"
            },
            "Italian": {
              "faceName": "",
              "name": "Morti di Llanowar",
              "text": "{T}: Aggiungi {B} alla tua riserva di mana.",
              "flavorText": "Così come dai rami di un albero vivo cadono le foglie, dal palazzo degli elfi cadono i morti.",
              "language": "Italian",
              "multiverseId": 0,
              "type": "Creatura — Elfo Zombie"
            },
            "Japanese": {
              "faceName": "",
              "name": "ラノワールの死者",
              "text": "",
              "flavorText": "",
              "language": "Japanese",
              "multiverseId": 0,
              "type": ""
            },
            "Portuguese (Brazil)": {
              "faceName": "",
              "name": "Mortos de Llanowar",
              "text": "",
              "flavorText": "",
              "language": "Portuguese (Brazil)",
              "multiverseId": 0,
              "type": ""
            }
          },
          "power": "2",
          "toughness": "2",
          "loyalty": "",
          "hand_modifier": "",
          "life_modifier": "",
          "has_alternative_deck_limit": false,
          "is_reserved": false,
          "printings": [
            "APC"
          ],
          "legalities": {
            "brawl": "Not Legal",
            "commander": "Legal",
            "duel": "Legal",
            "future": "Not Legal",
            "frontier": "Not Legal",
            "legacy": "Legal",
            "modern": "Not Legal",
            "pauper": "Legal",
            "penny": "Not Legal",
            "pioneer": "Not Legal",
            "standard": "Not Legal",
            "vintage": "Legal"
          },
          "leadership_skills": {
            "hasBrawl": false,
            "hasCommander": false,
            "hasOathbreaker": false
          },
          "edh_rec_rank": 9390,
          "identifiers": {
            "cardKingdomFoilId": "",
            "cardKingdomId": "",
            "mcmId": "",
            "mcmMetaId": "",
            "mtgArenaId": "",
            "mtgoFoilId": "",
            "mtgoId": "",
            "mtgjsonV4Id": "",
            "multiverseId": "",
            "scryfallId": "",
            "scryfallOracleId": "3a48541a-240b-4406-945c-1d0d032eca25",
            "scryfallIllustrationId": "",
            "tcgplayerProductId": ""
          }
        }
      }
    ]
  }
}
RESPONSE;

        return json_decode($response);
    }
}
