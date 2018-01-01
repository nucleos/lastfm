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

abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * Default Endpoint.
     */
    public const DEFAULT_WS_ENDPOINT = 'http://ws.audioscrobbler.com/2.0/';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $sharedSecret;

    /**
     * @var string
     */
    protected $uri;

    /**
     * AbstractConnection constructor.
     *
     * @param string $apikey
     * @param string $sharedSecret
     * @param string $uri
     */
    public function __construct(string $apikey, string $sharedSecret, string $uri = null)
    {
        if (null === $uri) {
            $uri = static::DEFAULT_WS_ENDPOINT;
        }

        $this->apiKey       = $apikey;
        $this->sharedSecret = $sharedSecret;
        $this->uri          = $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function signedCall(string $method, array $params = [], SessionInterface $session = null, $requestMethod = 'GET'): array
    {
        // Call parameter
        $callParams = [
            'method'  => $method,
            'api_key' => $this->apiKey,
        ];

        // Add session key
        if (null !== $session) {
            $callParams['sk'] = $session->getKey();
        }

        $params = array_merge($callParams, $params);
        $params = $this->filterNull($params);
        $params = $this->encodeUTF8($params);

        // Sign parameter
        $params['api_sig'] = $this->signParams($params);

        return $this->call($params, $requestMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function unsignedCall(string $method, array $params = [], string $requestMethod = 'GET'): array
    {
        // Call parameter
        $callParameter = [
            'method'  => $method,
            'api_key' => $this->apiKey,
        ];

        $params = array_merge($callParameter, $params);
        $params = $this->filterNull($params);
        $params = $this->encodeUTF8($params);

        return $this->call($params, $requestMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getSharedSecret(): string
    {
        return $this->sharedSecret;
    }

    /**
     * Performs the webservice call.
     *
     * @param array  $params
     * @param string $requestMethod
     *
     * @throws ApiException
     *
     * @return array
     */
    abstract protected function call(array $params, string $requestMethod = 'GET'): array;

    /**
     * Filter null values.
     *
     * @param array $object
     *
     * @return array
     */
    private function filterNull(array $object): array
    {
        return array_filter($object, function ($val) {
            return null !== $val;
        });
    }

    /**
     * Converts any string or array of strings to UTF8.
     *
     * @param string|string[] $object a String or an array
     *
     * @return string|string[] UTF8-string or array
     */
    private function encodeUTF8($object)
    {
        if (is_array($object)) {
            return array_map([$this, 'encodeUTF8'], $object);
        }

        return mb_convert_encoding((string) $object, 'UTF-8', 'auto');
    }

    /**
     * @param array $params
     *
     * @return string
     */
    private function signParams(array $params): string
    {
        ksort($params);

        $signature = '';
        foreach ($params as $name => $value) {
            $signature .= $name.$value;
        }
        $signature .= $this->sharedSecret;

        return md5($signature);
    }
}
