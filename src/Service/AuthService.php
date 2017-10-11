<?php

/*
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
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

final class AuthService extends AbstractService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

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
    public function __construct(ConnectionInterface $connection, string $authUrl = 'http://www.last.fm/api/auth/')
    {
        parent::__construct($connection);

        $this->authUrl = $authUrl;
        $this->logger  = new NullLogger();
    }

    /**
     * Creates a new session from a token.
     *
     * @param string $token
     *
     * @return SessionInterface|null
     */
    public function createSession(string $token): ? SessionInterface
    {
        try {
            $response = $this->signedCall('auth.getSession', array(
                'token' => $token,
            ));

            return new Session($response['session']['name'], $response['session']['key'], $response['session']['subscriber']);
        } catch (ApiException $e) {
            $this->logger->warning(sprintf('Error getting session for "%s" token.', $token), array(
                'exception' => $e,
            ));
        } catch (NotFoundException $e) {
            $this->logger->info(sprintf('No session was found for "%s" token.', $token), array(
                'exception' => $e,
            ));
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

        return $response['token'];
    }

    /**
     * Return the auth url.
     *
     * @param string $callbackUrl
     *
     * @return string
     */
    public function getAuthUrl(string $callbackUrl): string
    {
        return $this->authUrl.'?api_key='.$this->connection->getApiKey().'&cb='.$callbackUrl;
    }
}
