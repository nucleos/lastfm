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
     *@throws ApiException
     */
    public function call(string $url, array $params = [], string $method = 'GET'): array;

    public function getPageBody(string $url, array $params = [], string $method = 'GET'): ?string;
}
