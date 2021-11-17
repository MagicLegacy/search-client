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
