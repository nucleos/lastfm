<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Connection;

use Core23\LastFm\Exception\ApiException;

interface ConnectionInterface
{
    /**
     * Calls the API with signed session.
     *
     * @param string                $method
     * @param array                 $params
     * @param SessionInterface|null $session
     * @param string                $requestMethod
     *
     * @return array
     *
     * @throws ApiException
     */
    public function signedCall(string $method, array $params = array(), SessionInterface $session = null, $requestMethod = 'GET'): array;

    /**
     * Calls the API unsigned.
     *
     * @param string $method
     * @param array  $params
     * @param string $requestMethod
     *
     * @return array
     *
     * @throws ApiException
     */
    public function unsignedCall(string $method, array $params = array(), string $requestMethod = 'GET'): array;

    /**
     * Loads a page.
     *
     * @param string $url
     *
     * @return string
     */
    public function loadPage(string $url): string;

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
