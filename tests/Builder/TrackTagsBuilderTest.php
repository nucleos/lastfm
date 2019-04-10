<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Builder;

use Core23\LastFm\Builder\TrackTagsBuilder;
use PHPUnit\Framework\TestCase;

class TrackTagsBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = TrackTagsBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testForTrack(): void
    {
        $builder = TrackTagsBuilder::forTrack('Slipknot', 'Before I Forget');

        $expected = [
            'artist' => 'Slipknot',
            'track'  => 'Before I Forget',
        ];
        $this->assertSame($expected, $builder->getQuery());
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
        $this->assertSame($expected, $builder->getQuery());
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
        $this->assertSame($expected, $builder->getQuery());
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
        $this->assertSame($expected, $builder->getQuery());
    }
}
