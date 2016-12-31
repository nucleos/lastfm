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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

final class GuzzleConnection extends AbstractConnection
{
    /**
     * @var Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    public function loadPage($url)
    {
        $response = $this->getClient()->request('GET', $url);

        return $response->getBody()->getContents();
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        if (null === $this->client) {
            $this->client = new Client(array('base_uri' => $this->uri));
        }

        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    protected function call(array $params, $requestMethod = 'GET')
    {
        $params = array_merge($params, array('format' => 'json'));
        $data = $this->buildParameter($params);

        try {
            if ($requestMethod == 'POST') {
                $response = $this->getClient()->request($requestMethod, '', array(
                    'body' => $data,
                ));
            } else {
                $response = $this->getClient()->request($requestMethod, '?' . $data);
            }

            // Parse response
            return $this->parseResponse($response);
        } catch (ClientException $e) {
            $this->parseResponse($e->getResponse());
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
