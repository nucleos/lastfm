<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Service;

use Core23\LastFm\Connection\ConnectionInterface;
use Core23\LastFm\Service\AuthService;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    private $connection;

    protected function setUp()
    {
        $this->connection =  $this->prophesize(ConnectionInterface::class);
    }

    public function testItIsInstantiable(): void
    {
        $service = new AuthService($this->connection->reveal());

        $this->assertNotNull($service);
    }

    public function testCreateSession(): void
    {
        $this->connection->signedCall('auth.getSession', [
            'token' => 'user-token',
        ], null, 'GET')
            ->willReturn([
                'session' => [
                    'name'       => 'FooBar',
                    'key'        => 'the-key',
                    'subscriber' => 15,
                ],
            ])
        ;

        $service = new AuthService($this->connection->reveal());

        $result = $service->createSession('user-token');

        $this->assertNotNull($result);
        $this->assertSame('FooBar', $result->getName());
        $this->assertSame('the-key', $result->getKey());
        $this->assertSame(15, $result->getSubscriber());
    }

    public function testCreateToken(): void
    {
        $this->connection->signedCall('auth.getToken', [], null, 'GET')
            ->willReturn([
                'token' => 'The Token',
            ])
        ;

        $service = new AuthService($this->connection->reveal());
        $this->assertSame('The Token', $service->createToken());
    }

    public function testGetAuthUrl(): void
    {
        $this->connection->getApiKey()
            ->willReturn('api-key')
        ;

        $service = new AuthService($this->connection->reveal());

        $this->assertSame('http://www.last.fm/api/auth/?api_key=api-key&cb=https://example.org', $service->getAuthUrl('https://example.org'));
    }
}
