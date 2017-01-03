<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Connection;

use Core23\LastFm\Exception\ApiException;
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
    public function __construct(HttpClient $client, MessageFactory $messageFactory, $apikey, $sharedSecret, $uri = null)
    {
        parent::__construct($apikey, $sharedSecret, $uri);

        $this->client         = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function loadPage($url)
    {
        $request  = $this->messageFactory->createRequest('GET', $url);
        $response = $this->client->sendRequest($request);

        return $response->getBody()->getContents();
    }

    /**
     * {@inheritdoc}
     */
    protected function call(array $params, $requestMethod = 'GET')
    {
        try {
            $params = array_merge($params, array('format' => 'json'));
            $data   = $this->buildParameter($params);

            $request  = $this->messageFactory->createRequest($requestMethod, $this->uri, array(), $data);
            $response = $this->client->sendRequest($request);

            // Parse response
            return $this->parseResponse($response);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ApiException('Technical error occurred.', 500);
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     *
     * @throws ApiException
     */
    private function parseResponse(ResponseInterface $response)
    {
        $array = json_decode($response->getBody()->getContents(), true);

        if (is_array($array) && array_key_exists('error', $array) && array_key_exists('message', $array)) {
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
    private function buildParameter(array $parameter)
    {
        return http_build_query($parameter);
    }
}
