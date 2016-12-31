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
    final protected function toTimestamp(\DateTime $date = null)
    {
        if (null === $date) {
            return;
        }

        return $date->getTimestamp();
    }
}
