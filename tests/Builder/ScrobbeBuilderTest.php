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
use Nucleos\LastFm\Builder\ScrobbeBuilder;
use Nucleos\LastFm\Builder\TrackBuilder;
use PHPUnit\Framework\TestCase;

final class ScrobbeBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $builder = ScrobbeBuilder::create();

        $expected = [
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testCount(): void
    {
        $builder = ScrobbeBuilder::create();

        self::assertSame(0, $builder->count());
    }

    public function testAddTrack(): void
    {
        $now       = new DateTime();
        $yesterday = new DateTime('Yesterday');

        $builder = ScrobbeBuilder::create()
            ->addTrack(TrackBuilder::create('Slipknot', 'Before I Forget', $now))
            ->addTrack(TrackBuilder::create('The Beatles', 'Yesterday', $yesterday))
        ;

        $expected = [
            'artist[0]'    => 'Slipknot',
            'track[0]'     => 'Before I Forget',
            'timestamp[0]' => $now->getTimestamp(),
            'artist[1]'    => 'The Beatles',
            'track[1]'     => 'Yesterday',
            'timestamp[1]' => $yesterday->getTimestamp(),
        ];
        self::assertSame($expected, $builder->getQuery());
        self::assertSame(2, $builder->count());
    }
}
