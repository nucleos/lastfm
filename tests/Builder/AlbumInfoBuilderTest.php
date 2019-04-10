<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Builder;

use Core23\LastFm\Builder\AlbumInfoBuilder;
use PHPUnit\Framework\TestCase;

class AlbumInfoBuilderTest extends TestCase
{
    public function testForMbid(): void
    {
        $builder = AlbumInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f');

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testForAlbum(): void
    {
        $builder = AlbumInfoBuilder::forAlbum('Slipknot', 'IOWA');

        $expected = [
            'artist' => 'Slipknot',
            'album'  => 'IOWA',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testForUsername(): void
    {
        $builder = AlbumInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->forUsername('MyUser')
        ;

        $expected = [
            'mbid'     => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'username' => 'MyUser',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testLanguage(): void
    {
        $builder = AlbumInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->language('DE')
        ;

        $expected = [
            'mbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'lang' => 'DE',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testAutocorrect(): void
    {
        $builder = AlbumInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
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
        $builder = AlbumInfoBuilder::forMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
            ->autocorrect(false)
        ;

        $expected = [
            'mbid'        => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
            'autocorrect' => 0,
        ];
        $this->assertSame($expected, $builder->getQuery());
    }
}
