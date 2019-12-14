<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Builder;

use Core23\LastFm\Builder\ArtistInfoBuilder;
use PHPUnit\Framework\TestCase;

final class ArtistInfoBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = ArtistInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testForArtist(): void
    {
        $builder = ArtistInfoBuilder::forArtist('Slipknot');

        $expected = [
            'artist' => 'Slipknot',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testForUsername(): void
    {
        $builder = ArtistInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->forUsername('MyUser')
        ;

        $expected = [
            'mbid'     => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'username' => 'MyUser',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testLanguage(): void
    {
        $builder = ArtistInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->language('DE')
        ;

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'lang' => 'DE',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testAutocorrect(): void
    {
        $builder = ArtistInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
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
        $builder = ArtistInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(false)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 0,
        ];
        static::assertSame($expected, $builder->getQuery());
    }
}
