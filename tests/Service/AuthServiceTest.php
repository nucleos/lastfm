<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Service;

use Core23\LastFm\Client\ApiClientInterface;
use Core23\LastFm\Service\AuthService;
use PHPUnit\Framework\TestCase;

final class AuthServiceTest extends TestCase
{
    private $client;

    protected function setUp()
    {
        $this->client =  $this->prophesize(ApiClientInterface::class);
    }

    public function testItIsInstantiable(): void
    {
        $service = new AuthService($this->client->reveal());

        static::assertNotNull($service);
    }

    public function testCreateSession(): void
    {
        $this->client->signedCall('auth.getSession', [
            'token' => 'user-token',
        ])
            ->willReturn([
                'session' => [
                    'name'       => 'FooBar',
                    'key'        => 'the-key',
                    'subscriber' => 15,
                ],
            ])
        ;

        $service = new AuthService($this->client->reveal());

        $result = $service->createSession('user-token');

        static::assertNotNull($result);
        static::assertSame('FooBar', $result->getName());
        static::assertSame('the-key', $result->getKey());
        static::assertSame(15, $result->getSubscriber());
    }

    public function testCreateToken(): void
    {
        $this->client->signedCall('auth.getToken')
            ->willReturn([
                'token' => 'The Token',
            ])
        ;

        $service = new AuthService($this->client->reveal());
        static::assertSame('The Token', $service->createToken());
    }

    public function testGetAuthUrl(): void
    {
        $this->client->getApiKey()
            ->willReturn('api-key')
        ;

        $service = new AuthService($this->client->reveal());

        static::assertSame('http://www.last.fm/api/auth/?api_key=api-key&cb=https://example.org', $service->getAuthUrl('https://example.org'));
    }
}
