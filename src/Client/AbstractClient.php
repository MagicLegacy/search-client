<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Client;

use MagicLegacy\Component\Search\Exception\SearchClientException;
use MagicLegacy\Component\Search\Formatter\FormatterInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Log\LoggerInterface;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;

/**
 * Class AbstractClient
 *
 * Exception code range: 1000-1049
 *
 *
 * @author Romain Cottard
 */
class AbstractClient
{
    private ClientInterface $client;
    private RequestFactoryInterface $requestFactory;
    private UriFactoryInterface $uriFactory;
    private StreamFactoryInterface $streamFactory;
    private LoggerInterface $logger;
    private string $baseUrl;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        StreamFactoryInterface $streamFactory,
        LoggerInterface $logger,
        string $baseUrl = 'http://localhost:9200'
    ) {
        $this->client         = $client;
        $this->logger         = $logger;
        $this->requestFactory = $requestFactory;
        $this->uriFactory     = $uriFactory;
        $this->streamFactory  = $streamFactory;
        $this->baseUrl        = $baseUrl;
    }

    /**
     * @param string $path
     * @param FormatterInterface $formatter
     * @return mixed
     * @throws SearchClientException
     */
    final protected function fetchResult(string $path, FormatterInterface $formatter)
    {
        $response    = null;
        $decodedData = null;

        try {
            $request  = $this->getRequest($path);
            $response = $this->client->sendRequest($request);

            $data = $response->getBody()->getContents();

            if (!empty($data)) {
                $decodedData = json_decode($data);
            }

            if ($response->getStatusCode() >= 400) {
                throw new SearchClientException();
            }
        } catch (SearchClientException $exception) {
            $code    = $this->getErrorCode($decodedData, $response);
            $message = $this->getErrorMessage($decodedData, $response, $code);

            throw new SearchClientException($message, $code, $exception);
        } catch (JsonException $exception) {
            throw new SearchClientException('[CLI-3001] Unable to decode json response!', 3001, $exception);
        } catch (ClientExceptionInterface $exception) {
            throw new SearchClientException('[CLI-3000] ' . $exception->getMessage(), 3000, $exception);
        } finally {
            if (!empty($exception) && $exception instanceof \Exception) {
                $this->getLogger()->notice($exception->getMessage(), [
                    'type'      => 'component.mtgjson.client.fetch',
                    'exception' => $exception,
                ]);
            }
        }

        return $decodedData !== null ? $formatter->format($decodedData) : $decodedData;
    }

    /**
     * @param string $path
     * @return RequestInterface
     */
    protected function getRequest(string $path): RequestInterface
    {
        $uri     = $this->uriFactory->createUri($this->baseUrl . $path);
        $request = $this->requestFactory->createRequest('GET', $uri);

        //~ Add header
        return $request
            ->withAddedHeader('Accept', 'application/json')
        ;
    }

    /**
     * @return LoggerInterface
     */
    final protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param mixed $data
     * @param ResponseInterface|null $response
     * @return int
     */
    private function getErrorCode($data, ?ResponseInterface $response): int
    {
        $code = 3002;

        if (!empty($data->errors)) {
            $code = 3004;
        } elseif ($response !== null && $response->getStatusCode() >= 400) {
            $code = 3003;
        }

        return $code;
    }

    /**
     * @param $data
     * @param ResponseInterface $response
     * @param int $internalCode
     * @return string
     */
    private function getErrorMessage($data, ResponseInterface $response, int $internalCode): string
    {
        $error = !empty($data->error->root_cause) && is_object($data->error->root_cause) ? $data->error->root_cause : null;

        $prefix = '[CLI-' . $internalCode . '] ';

        //~ Override default prefix
        if ($response->getStatusCode() >= 400) {
            $prefix = '[HTTP-' . $response->getStatusCode() . '] ';
        }

        $message = $error->reason ?? 'An error as occurred!';

        return $prefix . $message;
    }
}
