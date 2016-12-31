<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Connection\Session;
use Core23\LastFm\Connection\SessionInterface;
use Core23\LastFm\Exception\ApiException;

final class AuthService extends AbstractService
{
    /**
     * Creates a new session from a token.
     *
     * @param string $token
     *
     * @return SessionInterface|null
     *
     * @throws ApiException
     */
    public function createSession($token)
    {
        $response = $this->connection->signedCall('auth.getSession', array(
            'token' => $token,
        ));

        if ($response) {
            return new Session($response['session']['name'], $response['session']['key'], $response['session']['subscriber']);
        }

        return;
    }

    /**
     * Creates a new api token.
     *
     * @return string|false
     *
     * @throws ApiException
     */
    public function createToken()
    {
        $response = $this->connection->signedCall('auth.getToken');

        if ($response) {
            return $response['token'];
        }

        return false;
    }
}
