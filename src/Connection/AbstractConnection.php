<?php

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
    const DEFAULT_WS_ENDPOINT = 'http://ws.audioscrobbler.com/2.0/';

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
    public function __construct($apikey, $sharedSecret, $uri = null)
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
    public function signedCall($method, array $params = array(), SessionInterface $session = null, $requestMethod = 'GET')
    {
        // Call parameter
        $callParams = array(
            'method'  => $method,
            'api_key' => $this->apiKey,
        );

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
    public function unsignedCall($method, array $params = array(), $requestMethod = 'GET')
    {
        // Call parameter
        $callParameter = array(
            'method'  => $method,
            'api_key' => $this->apiKey,
        );

        $params = array_merge($callParameter, $params);
        $params = $this->filterNull($params);
        $params = $this->encodeUTF8($params);

        return $this->call($params, $requestMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getSharedSecret()
    {
        return $this->sharedSecret;
    }

    /**
     * Performs the webservice call.
     *
     * @param array  $params
     * @param string $requestMethod
     *
     * @return array
     *
     * @throws ApiException
     */
    abstract protected function call(array $params, $requestMethod = 'GET');

    /**
     * Filter null values.
     *
     * @param array $object
     *
     * @return array
     */
    private function filterNull($object)
    {
        return array_filter($object, function ($val) {
            return !is_null($val);
        });
    }

    /** Converts any string or array of strings to UTF8.
     * @param mixed $object a String or an array
     *
     * @return mixed uTF8-string or array
     */
    private function encodeUTF8($object)
    {
        if (is_array($object)) {
            return array_map(array($this, 'encodeUTF8'), $object);
        }

        return mb_convert_encoding($object, 'UTF-8', 'auto');
    }

    /**
     * {@inheritdoc}
     */
    private function signParams(array $params)
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
