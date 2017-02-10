<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Connection;

final class Session implements SessionInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $subscriber;

    /**
     * Session constructor.
     *
     * @param string $name
     * @param string $key
     * @param int    $subscriber
     */
    public function __construct(string $name, string $key, int $subscriber = 0)
    {
        $this->name       = $name;
        $this->key        = $key;
        $this->subscriber = $subscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriber() : int
    {
        return $this->subscriber;
    }
}
