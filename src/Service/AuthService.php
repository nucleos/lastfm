<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Client\ApiClientInterface;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;
use Core23\LastFm\Session\Session;
use Core23\LastFm\Session\SessionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

final class AuthService implements LoggerAwareInterface, AuthServiceInterface
{
    use LoggerAwareTrait;

    /**
     * @var string
     */
    private $authUrl;

    /**
     * @var ApiClientInterface
     */
    private $client;

    public function __construct(ApiClientInterface $connection, string $authUrl = 'http://www.last.fm/api/auth/')
    {
        $this->client  = $connection;
        $this->authUrl = $authUrl;
        $this->logger  = new NullLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function createSession(string $token): ?SessionInterface
    {
        try {
            $response = $this->client->signedCall('auth.getSession', [
                'token' => $token,
            ]);

            return new Session($response['session']['name'], $response['session']['key'], $response['session']['subscriber']);
        } catch (ApiException $e) {
            $this->logger->warning(sprintf('Error getting session for "%s" token.', $token), [
                'exception' => $e,
            ]);
        } catch (NotFoundException $e) {
            $this->logger->info(sprintf('No session was found for "%s" token.', $token), [
                'exception' => $e,
            ]);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function createToken(): ?string
    {
        $response = $this->client->signedCall('auth.getToken');

        return $response['token'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthUrl(string $callbackUrl): string
    {
        return $this->authUrl.'?api_key='.$this->client->getApiKey().'&cb='.$callbackUrl;
    }
}
