<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Builder;

use Nucleos\LastFm\Builder\SimilarArtistBuilder;
use PHPUnit\Framework\TestCase;

final class SimilarArtistBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = SimilarArtistBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testForArtist(): void
    {
        $builder = SimilarArtistBuilder::forArtist('Slipknot');

        $expected = [
            'artist' => 'Slipknot',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testAutocorrect(): void
    {
        $builder = SimilarArtistBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(true)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 1,
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testNoAutocorrect(): void
    {
        $builder = SimilarArtistBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(false)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 0,
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testLimit(): void
    {
        $builder = SimilarArtistBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->limit(13)
        ;

        $expected = [
            'mbid'     => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'limit'    => 13,
        ];
        self::assertSame($expected, $builder->getQuery());
    }
}
