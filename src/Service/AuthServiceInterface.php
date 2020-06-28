<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Service;

use Nucleos\LastFm\Exception\ApiException;
use Nucleos\LastFm\Exception\NotFoundException;
use Nucleos\LastFm\Session\SessionInterface;

interface AuthServiceInterface
{
    /**
     * Creates a new session from a token.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function createSession(string $token): ?SessionInterface;

    /**
     * Creates a new api token.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function createToken(): ?string;

    /**
     * Return the auth url.
     */
    public function getAuthUrl(string $callbackUrl): string;
}
