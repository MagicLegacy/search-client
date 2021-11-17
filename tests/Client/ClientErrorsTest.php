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
use MagicLegacy\Component\Search\Exception\SearchClientException;
use MagicLegacy\Component\Search\Exception\SearchComponentException;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\NullLogger;

/**
 * Class ClientErrorsTest
 */
class ClientErrorsTest extends TestCase
{
    /**
     * @return void
     * @throws SearchComponentException
     * @throws ClientExceptionInterface
     */
    public function testAnExceptionIsThrownWithDefaultMessageWhenResponseHaveBasicContentWithHttpErrorCode(): void
    {
        $this->expectException(SearchClientException::class);
        $this->expectExceptionCode(3003);
        $this->expectExceptionMessage('[HTTP-400] An error as occurred!');

        $this->getClient(400, $this->getMinimalResponse())->searchAtomicCards('name:llanowar');
    }

    /**
     * @return void
     * @throws SearchComponentException
     * @throws ClientExceptionInterface
     */
    public function testAnExceptionIsThrownWhenResponseHaveInvalidJsonContent(): void
    {
        $this->expectException(SearchClientException::class);
        $this->expectExceptionCode(3001);
        $this->expectExceptionMessage('[CLI-3001] Unable to decode json response!');

        $this->getClient(200, $this->getInvalidJsonResponse())->searchAtomicCards('name:llanowar');
    }

    /**
     * @param int $status
     * @param string $body
     * @param null $exception
     * @return SearchClient
     */
    private function getClient(int $status, string $body, $exception = null): SearchClient
    {
        $httpFactory = new Psr17Factory();
        $response = $httpFactory->createResponse($status);
        $response->getBody()->write($body);
        $response->getBody()->rewind();

        $httpClientMock = $this->createMock(ClientInterface::class);

        if (!empty($exception)) {
            $httpClientMock
                ->method('sendRequest')
                ->willThrowException($exception)
            ;
        } else {
            $httpClientMock
                ->method('sendRequest')
                ->willReturn($response);
        }

        return new SearchClient($httpClientMock, $httpFactory, $httpFactory, $httpFactory, new NullLogger());
    }

    /**
     * @return string
     */
    private function getMinimalResponse(): string
    {
        return '{"error": { "root_cause": {} } }';
    }

    /**
     * @return string
     */
    private function getDetailedErrorResponse(): string
    {
        return <<<'RESPONSE'
        {
          "error": {
            "root_cause": [
              {
                "type": "query_shard_exception",
                "reason": "Failed to parse query [name:llanowar AND power:[1,2]]",
                "index_uuid": "3CI8W1YzRGKECCltnE7gDw",
                "index": "atomic"
              }
            ],
            "type": "search_phase_execution_exception",
            "reason": "all shards failed",
            "phase": "query",
            "grouped": true,
            "failed_shards": [
              {
                "shard": 0,
                "index": "atomic",
                "node": "7vdWVZ3uQauP22aHaenACg",
                "reason": {
                  "type": "query_shard_exception",
                  "reason": "Failed to parse query [name:llanowar AND power:[1,2]]",
                  "index_uuid": "3CI8W1YzRGKECCltnE7gDw",
                  "index": "atomic",
                  "caused_by": {
                    "type": "parse_exception",
                    "reason": "Cannot parse 'name:llanowar AND power:[1,2]': Encountered \" \"]\" \"] \"\" at line 1, column 28.\nWas expecting:\n    \"TO\" ...\n    ",
                    "caused_by": {
                      "type": "parse_exception",
                      "reason": "Encountered \" \"]\" \"] \"\" at line 1, column 28.\nWas expecting:\n    \"TO\" ...\n    "
                    }
                  }
                }
              }
            ]
          },
          "status": 400
        }
        RESPONSE;
    }

    /**
     * @return string
     */
    private function getInvalidJsonResponse(): string
    {
        return '[';
    }
}
