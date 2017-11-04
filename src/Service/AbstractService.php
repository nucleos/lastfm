<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Connection\ConnectionInterface;
use Core23\LastFm\Connection\SessionInterface;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;

abstract class AbstractService
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * AbstractService constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Formats a date to a timestamp.
     *
     * @param \DateTime|null $date
     *
     * @return int|null
     */
    final protected function toTimestamp(\DateTime $date = null): ? int
    {
        if (null === $date) {
            return null;
        }

        return $date->getTimestamp();
    }

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
     * @throws NotFoundException
     */
    final protected function signedCall($method, array $params = array(), SessionInterface $session = null, $requestMethod = 'GET') : array
    {
        try {
            return $this->connection->signedCall($method, $params, $session, $requestMethod);
        } catch (ApiException $e) {
            if (6 == $e->getCode()) {
                throw new NotFoundException('No entity was found for your request.', $e->getCode(), $e);
            }

            throw $e;
        }
    }

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
     * @throws NotFoundException
     */
    final protected function unsignedCall($method, array $params = array(), $requestMethod = 'GET'): array
    {
        try {
            return $this->connection->unsignedCall($method, $params, $requestMethod);
        } catch (ApiException $e) {
            if (6 == $e->getCode()) {
                throw new NotFoundException('No entity was found for your request.', $e->getCode(), $e);
            }

            throw $e;
        }
    }
}
