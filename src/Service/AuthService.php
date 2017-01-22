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

use Core23\LastFm\Connection\ConnectionInterface;
use Core23\LastFm\Connection\Session;
use Core23\LastFm\Connection\SessionInterface;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;

final class AuthService extends AbstractService
{
    /**
     * @var string
     */
    private $authUrl;

    /**
     * AuthService constructor.
     *
     * @param ConnectionInterface $connection
     * @param string              $authUrl
     */
    public function __construct(ConnectionInterface $connection, $authUrl = 'http://www.last.fm/api/auth/')
    {
        parent::__construct($connection);

        $this->authUrl = $authUrl;
    }

    /**
     * Creates a new session from a token.
     *
     * @param string $token
     *
     * @return SessionInterface|null
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function createSession($token)
    {
        $response = $this->signedCall('auth.getSession', array(
            'token' => $token,
        ));

        if ($response) {
            return new Session($response['session']['name'], $response['session']['key'], $response['session']['subscriber']);
        }

        return null;
    }

    /**
     * Creates a new api token.
     *
     * @return string|false
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function createToken()
    {
        $response = $this->signedCall('auth.getToken');

        if ($response) {
            return $response['token'];
        }

        return false;
    }

    /**
     * Return the auth url.
     *
     * @param string $callbackUrl
     *
     * @return string
     */
    public function getAuthUrl($callbackUrl)
    {
        return $this->authUrl.'?api_key='.$this->connection->getApiKey().'&cb='.$callbackUrl;
    }
}
