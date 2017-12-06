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
     * Loads a page and returns the page body.
     *
     * @param string $url
     *
     * @return string|null
     */
    public function getPageBody(string $url): ?string;

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
