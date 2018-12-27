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

final class HTTPlugConnection extends AbstractConnection
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
     * Initialize client.
     *
     * @param HttpClient     $client
     * @param MessageFactory $messageFactory
     * @param string         $apikey
     * @param string         $sharedSecret
     * @param string         $uri
     */
    public function __construct(HttpClient $client, MessageFactory $messageFactory, string $apikey, string $sharedSecret, string $uri = null)
    {
        parent::__construct($apikey, $sharedSecret, $uri);

        $this->client         = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param string $url
     *
     * @throws Exception
     *
     * @return string|null
     */
    public function getPageBody(string $url): ?string
    {
        $request  = $this->messageFactory->createRequest('GET', $url);
        $response = $this->client->sendRequest($request);

        if ($response->getStatusCode() >= 400) {
            return null;
        }

        return $response->getBody()->getContents();
    }

    /**
     * {@inheritdoc}
     */
    protected function call(array $params, string $requestMethod = 'GET'): array
    {
        $params  = array_merge($params, ['format' => 'json']);
        $data    = $this->buildParameter($params);
        $request = $this->messageFactory->createRequest($requestMethod, $this->uri, [], $data);

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

        if (\is_array($array) && array_key_exists('error', $array) && array_key_exists('message', $array)) {
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
