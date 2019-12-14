<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Builder;

use Core23\LastFm\Builder\ArtistTopTracksBuilder;
use PHPUnit\Framework\TestCase;

final class ArtistTopTracksBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = ArtistTopTracksBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testForArtist(): void
    {
        $builder = ArtistTopTracksBuilder::forArtist('Slipknot');

        $expected = [
            'artist' => 'Slipknot',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testAutocorrect(): void
    {
        $builder = ArtistTopTracksBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
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
        $builder = ArtistTopTracksBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(false)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 0,
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testLimit(): void
    {
        $builder = ArtistTopTracksBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->limit(20)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'limit'       => 20,
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testPage(): void
    {
        $builder = ArtistTopTracksBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->page(13)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'page'        => 13,
        ];
        static::assertSame($expected, $builder->getQuery());
    }
}
