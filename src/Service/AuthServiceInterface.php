<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Connection\SessionInterface;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;

interface AuthServiceInterface
{
    /**
     * Creates a new session from a token.
     *
     * @param string $token
     *
     * @return SessionInterface|null
     */
    public function createSession(string $token): ?SessionInterface;

    /**
     * Creates a new api token.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return string|null
     */
    public function createToken(): ?string;

    /**
     * Return the auth url.
     *
     * @param string $callbackUrl
     *
     * @return string
     */
    public function getAuthUrl(string $callbackUrl): string;
}
