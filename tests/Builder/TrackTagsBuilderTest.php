<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Builder;

use Nucleos\LastFm\Builder\TrackTagsBuilder;
use PHPUnit\Framework\TestCase;

final class TrackTagsBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = TrackTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testForTrack(): void
    {
        $builder = TrackTagsBuilder::forTrack('Slipknot', 'Before I Forget');

        $expected = [
            'artist' => 'Slipknot',
            'track'  => 'Before I Forget',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testForUsername(): void
    {
        $builder = TrackTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->forUsername('MyUser')
        ;

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'user' => 'MyUser',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testAutocorrect(): void
    {
        $builder = TrackTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
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
        $builder = TrackTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(false)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 0,
        ];
        self::assertSame($expected, $builder->getQuery());
    }
}
