<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Builder;

use Core23\LastFm\Builder\ScrobbeBuilder;
use Core23\LastFm\Builder\TrackBuilder;
use DateTime;
use PHPUnit\Framework\TestCase;

class ScrobbeBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $builder = ScrobbeBuilder::create();

        $expected = [
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testCount(): void
    {
        $builder = ScrobbeBuilder::create();

        $this->assertSame(0, $builder->count());
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
        $this->assertSame($expected, $builder->getQuery());
        $this->assertSame(2, $builder->count());
    }
}
