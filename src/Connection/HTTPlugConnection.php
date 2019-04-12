<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Connection;

use Core23\LastFm\Exception\ApiException;
use Http\Client\Exception;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;

final class HTTPlugConnection implements ConnectionInterface
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * Initialize client.
     *
     * @param HttpClient     $client
     * @param MessageFactory $messageFactory
     * @param string         $endpoint
     */
    public function __construct(HttpClient $client, MessageFactory $messageFactory, string $endpoint = ConnectionInterface::DEFAULT_ENDPOINT)
    {
        $this->client         = $client;
        $this->messageFactory = $messageFactory;
        $this->endpoint       = $endpoint;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageBody(string $url, string $method = 'GET'): ?string
    {
        $request  = $this->messageFactory->createRequest($method, $url);

        try {
            $response = $this->client->sendRequest($request);
        } catch (Exception $e) {
            throw new ApiException('Error fetching page body', $e->getCode(), $e->getMessage());
        }

        if ($response->getStatusCode() >= 400) {
            return null;
        }

        return $response->getBody()->getContents();
    }

    /**
     * {@inheritdoc}
     */
    public function call(string $method, array $params = [], string $requestMethod = 'GET'): array
    {
        $params  = array_merge($params, ['format' => 'json']);
        $data    = $this->buildParameter($params);
        $request = $this->messageFactory->createRequest($requestMethod, $this->endpoint, [], $data);

        try {
            $response = $this->client->sendRequest($request);

            // Parse response
            return $this->parseResponse($response);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ApiException('Technical error occurred.', 500, $e);
        } catch (Exception $e) {
            throw new ApiException('Technical error occurred.', $e->getCode(), $e);
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws ApiException
     *
     * @return array
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $array = json_decode($response->getBody()->getContents(), true);

        if (\is_array($array) && \array_key_exists('error', $array) && \array_key_exists('message', $array)) {
            throw new ApiException($array['message'], $array['error']);
        }

        return $array;
    }

    /**
     * Builds request parameter.
     *
     * @param array $parameter
     *
     * @return string
     */
    private function buildParameter(array $parameter): string
    {
        return http_build_query($parameter);
    }
}
