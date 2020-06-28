<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Builder;

use DateTime;
use Nucleos\LastFm\Builder\TrackBuilder;
use PHPUnit\Framework\TestCase;

final class TrackBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now);

        $expected = [
            'artist'    => 'Slipknot',
            'track'     => 'Before I Forget',
            'timestamp' => $now->getTimestamp(),
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithAlbum(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withAlbum('IOWA')
        ;

        $expected = [
            'artist'    => 'Slipknot',
            'track'     => 'Before I Forget',
            'timestamp' => $now->getTimestamp(),
            'album'     => 'IOWA',
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithAlbumArtist(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withAlbumArtist('Slipknot')
        ;

        $expected = [
            'artist'      => 'Slipknot',
            'track'       => 'Before I Forget',
            'timestamp'   => $now->getTimestamp(),
            'albumArtist' => 'Slipknot',
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithChosenByUser(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withChosenByUser(true)
        ;

        $expected = [
            'artist'       => 'Slipknot',
            'track'        => 'Before I Forget',
            'timestamp'    => $now->getTimestamp(),
            'chosenByUser' => 1,
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithTrackNumber(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withTrackNumber(11)
        ;

        $expected = [
            'artist'      => 'Slipknot',
            'track'       => 'Before I Forget',
            'timestamp'   => $now->getTimestamp(),
            'trackNumber' => 11,
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithStreamId(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withStreamId(11)
        ;

        $expected = [
            'artist'    => 'Slipknot',
            'track'     => 'Before I Forget',
            'timestamp' => $now->getTimestamp(),
            'streamId'  => 11,
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithContext(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withContext('Client Version')
        ;

        $expected = [
            'artist'    => 'Slipknot',
            'track'     => 'Before I Forget',
            'timestamp' => $now->getTimestamp(),
            'context'   => 'Client Version',
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithMbid(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
        ;

        $expected = [
            'artist'    => 'Slipknot',
            'track'     => 'Before I Forget',
            'timestamp' => $now->getTimestamp(),
            'mbid'      => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        static::assertSame($expected, $builder->getData());
    }

    public function testWithDuration(): void
    {
        $now = new DateTime();

        $builder = TrackBuilder::create('Slipknot', 'Before I Forget', $now)
            ->withDuration(183)
        ;

        $expected = [
            'artist'    => 'Slipknot',
            'track'     => 'Before I Forget',
            'timestamp' => $now->getTimestamp(),
            'duration'  => 183,
        ];
        static::assertSame($expected, $builder->getData());
    }
}
