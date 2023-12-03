<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Session;

use Nucleos\LastFm\Session\Session;
use PHPUnit\Framework\TestCase;

final class SessionTest extends TestCase
{
    public function testGetName(): void
    {
        $session = new Session('Username', 'key');

        self::assertSame('Username', $session->getName());
    }

    public function testGetKey(): void
    {
        $session = new Session('Username', 'key');

        self::assertSame('key', $session->getKey());
    }

    public function testGetSubscriber(): void
    {
        $session = new Session('Username', 'key', 32);

        self::assertSame(32, $session->getSubscriber());
    }
}
