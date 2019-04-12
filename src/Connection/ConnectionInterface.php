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
     * Default Endpoint.
     */
    public const DEFAULT_ENDPOINT = 'http://ws.audioscrobbler.com/2.0/';

    /**
     * Calls the API.
     *
     * @param string $method
     * @param array  $params
     * @param string $requestMethod
     *
     * @throws ApiException
     *
     * @return array
     */
    public function call(string $method, array $params = [], string $requestMethod = 'GET'): array;

    /**
     * @param string $url
     *
     * @throws ApiException
     *
     * @return string|null
     */
    public function getPageBody(string $url): ?string;
}
