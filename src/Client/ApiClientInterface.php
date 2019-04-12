<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Client;

use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Session\SessionInterface;

interface ApiClientInterface
{
    /**
     * Calls the API with signed session.
     *
     * @param string                $method
     * @param array                 $params
     * @param SessionInterface|null $session
     * @param string                $requestMethod
     *
     * @throws ApiException
     *
     * @return array
     */
    public function signedCall(string $method, array $params = [], SessionInterface $session = null, $requestMethod = 'GET'): array;

    /**
     * Calls the API unsigned.
     *
     * @param string $method
     * @param array  $params
     * @param string $requestMethod
     *
     * @throws ApiException
     *
     * @return array
     */
    public function unsignedCall(string $method, array $params = [], string $requestMethod = 'GET'): array;

    /**
     * Get the api key.
     *
     * @return string
     */
    public function getApiKey(): string;

    /**
     * Get the shared secret.
     *
     * @return string
     */
    public function getSharedSecret(): string;
}
