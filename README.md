# search-client


[![Current version](https://img.shields.io/packagist/v/magiclegacy/search-client.svg?logo=composer)](https://packagist.org/packages/magiclegacy/search-client)
[![Supported PHP version](https://img.shields.io/static/v1?logo=php&label=PHP&message=%5E7.4&color=777bb4)](https://packagist.org/packages/magiclegacy/search-client)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=MagicLegacy_search-client&metric=coverage)](https://sonarcloud.io/dashboard?id=MagicLegacy_search-client)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=MagicLegacy_search-client&metric=alert_status)](https://sonarcloud.io/dashboard?id=MagicLegacy_search-client)
[![CI](https://github.com/MagicLegacy/search-client/workflows/CI/badge.svg)](https://github.com/MagicLegacy/search-client/actions)

Search Client for magic card in ElasticSearch engine

Supported search (related to Atomic Card from mtgjson.org, with some minor field renaming):
* `/atomic/_search`: ElasticSearch index with name `atomic` for all atomics cards

## Composer
```bash
composer require magiclegacy/search-client
```

## Usage in application
```php
<?php
namespace Application;

use MagicLegacy\Component\Search\Client\SearchClient;
use Eureka\Component\Curl;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Log\NullLogger;

require_once __DIR__ . '/../vendor/autoload.php';

//~ Declare tier required services (included as dependencies)
$httpFactory  = new Psr17Factory();
$searchClient = new SearchClient(
    new Curl\HttpClient(),
    $httpFactory,
    $httpFactory,
    $httpFactory,
    new NullLogger()
);

$cards = $searchClient->searchAtomicCards('name:llanowar types:creature power:1 OR power:2');

foreach ($cards as $card) {

    echo (string) $card->getName() . ' - ' . $card->getPower() . '/' . $card->getToughness() . PHP_EOL;
}
```
see: [example.php](./examples/search.php)

The output will be:
```text
Llanowar Cavalry - 1/4
Llanowar Druid - 1/2
Llanowar Elite - 1/1
Llanowar Elves - 1/1
Llanowar Mentor - 1/1
Llanowar Scout - 1/3
Llanowar Vanguard - 1/1
Llanowar Dead - 2/2
Llanowar Empath - 2/2
Llanowar Knight - 2/2

```

## SearchClient

### About Atomic Cards

Available methods:
* `SearchClient::searchAtomicCards()`: `AtomicCard[]`
