<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Builder;

use Nucleos\LastFm\Builder\TrackInfoBuilder;
use PHPUnit\Framework\TestCase;

final class TrackInfoBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = TrackInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testForArtist(): void
    {
        $builder = TrackInfoBuilder::forArtist('Slipknot');

        $expected = [
            'artist' => 'Slipknot',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testForUsername(): void
    {
        $builder = TrackInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->forUsername('MyUser')
        ;

        $expected = [
            'mbid'     => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'username' => 'MyUser',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testAutocorrect(): void
    {
        $builder = TrackInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(true)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 1,
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testNoAutocorrect(): void
    {
        $builder = TrackInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(false)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 0,
        ];
        static::assertSame($expected, $builder->getQuery());
    }
}
