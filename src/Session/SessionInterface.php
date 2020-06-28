<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Session;

interface SessionInterface
{
    /**
     * Returns name.
     */
    public function getName(): string;

    /**
     * Returns key.
     */
    public function getKey(): string;

    /**
     * Returns subscriber.
     */
    public function getSubscriber(): int;
}
