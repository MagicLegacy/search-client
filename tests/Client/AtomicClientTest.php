<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Tests\Client;

use MagicLegacy\Component\Search\Client\SearchClient;
use MagicLegacy\Component\Search\Entity\CardAtomic;
use MagicLegacy\Component\Search\Exception\SearchComponentException;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\NullLogger;

/**
 * Class SearchClientTest
 */
class SearchClientTest extends TestCase
{
    /**
     * @return void
     * @throws SearchComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanSearchForAtomicCards(): void
    {
        $allCards = $this->getClient()->searchAtomicCards('name:llanowar');

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws SearchComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestAtomicEndpointWithoutCardsAndHaveAnEmptyAtomicCardList(): void
    {
        $allCards = $this->getClient(true)->searchAtomicCards('name:llanowar');

        $this->assertCount(0, $allCards);
    }

    /**
     * @param bool $emptyContent
     * @return SearchClient
     */
    private function getClient(bool $emptyContent = false): SearchClient
    {
        $httpFactory = new Psr17Factory();
        $response = $httpFactory->createResponse();
        $response->getBody()->write($this->getJsonResponse($emptyContent));
        $response->getBody()->rewind();

        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock
            ->method('sendRequest')
            ->willReturn($response)
        ;

        return new SearchClient($httpClientMock, $httpFactory, $httpFactory, $httpFactory, new NullLogger());
    }

    /**
     * @param bool $emptyContent
     * @return string
     */
    private function getJsonResponse(bool $emptyContent = false): string
    {
        if ($emptyContent) {
            return '{"took":3,"timed_out":false,"_shards":{"total":1,"successful":1,"skipped":0,"failed":0},"hits":{"total":{"value":0,"relation":"eq"},"max_score":null,"hits":[]}}';
        }

        return <<<'RESPONSE'
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
    }
}
