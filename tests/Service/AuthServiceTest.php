<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Service;

use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Service\AuthService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class AuthServiceTest extends TestCase
{
    /**
     * @var MockObject&ApiClientInterface
     */
    private ApiClientInterface $client;

    protected function setUp(): void
    {
        $this->client =  $this->createMock(ApiClientInterface::class);
    }

    public function testCreateSession(): void
    {
        $this->client->method('signedCall')->with('auth.getSession', [
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

        $service = new AuthService($this->client);

        $result = $service->createSession('user-token');

        static::assertNotNull($result);
        static::assertSame('FooBar', $result->getName());
        static::assertSame('the-key', $result->getKey());
        static::assertSame(15, $result->getSubscriber());
    }

    public function testCreateToken(): void
    {
        $this->client->method('signedCall')->with('auth.getToken')
            ->willReturn([
                'token' => 'The Token',
            ])
        ;

        $service = new AuthService($this->client);
        static::assertSame('The Token', $service->createToken());
    }

    public function testGetAuthUrl(): void
    {
        $this->client->method('getApiKey')
            ->willReturn('api-key')
        ;

        $service = new AuthService($this->client);

        static::assertSame('http://www.last.fm/api/auth/?api_key=api-key&cb=https://example.org', $service->getAuthUrl('https://example.org'));
    }
}
