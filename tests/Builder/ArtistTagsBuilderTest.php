<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Builder;

use Nucleos\LastFm\Builder\ArtistTagsBuilder;
use PHPUnit\Framework\TestCase;

final class ArtistTagsBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = ArtistTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testForArtist(): void
    {
        $builder = ArtistTagsBuilder::forArtist('Slipknot');

        $expected = [
            'artist' => 'Slipknot',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testForUsername(): void
    {
        $builder = ArtistTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->forUsername('MyUser')
        ;

        $expected = [
            'mbid'     => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'user'     => 'MyUser',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testAutocorrect(): void
    {
        $builder = ArtistTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
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
        $builder = ArtistTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(false)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 0,
        ];
        static::assertSame($expected, $builder->getQuery());
    }
}
