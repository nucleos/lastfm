<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Service;

use Core23\LastFm\Client\ApiClientInterface;
use Core23\LastFm\Service\LibraryService;
use PHPUnit\Framework\TestCase;

final class LibraryServiceTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client =  $this->prophesize(ApiClientInterface::class);
    }

    public function testGetArtists(): void
    {
        $rawResponse = <<<'EOD'
a:1:{s:7:"artists";a:2:{s:6:"artist";a:7:{s:3:"url";s:39:"https://www.last.fm/music/36+Crazyfists";s:4:"mbid";s:36:"781167d7-b9e5-48ea-9f66-67c4a6739562";s:8:"tagcount";s:1:"0";s:9:"playcount";s:5:"17223";s:10:"streamable";s:1:"0";s:4:"name";s:13:"36 Crazyfists";s:5:"image";a:5:{i:0;a:2:{s:4:"size";s:5:"small";s:5:"#text";s:78:"https://lastfm-img2.akamaized.net/i/u/34s/e0bc9ea72a894e37a1efaafaf6a33dd3.jpg";}i:1;a:2:{s:4:"size";s:6:"medium";s:5:"#text";s:78:"https://lastfm-img2.akamaized.net/i/u/64s/e0bc9ea72a894e37a1efaafaf6a33dd3.jpg";}i:2;a:2:{s:4:"size";s:5:"large";s:5:"#text";s:79:"https://lastfm-img2.akamaized.net/i/u/174s/e0bc9ea72a894e37a1efaafaf6a33dd3.jpg";}i:3;a:2:{s:4:"size";s:10:"extralarge";s:5:"#text";s:82:"https://lastfm-img2.akamaized.net/i/u/300x300/e0bc9ea72a894e37a1efaafaf6a33dd3.jpg";}i:4;a:2:{s:4:"size";s:4:"mega";s:5:"#text";s:82:"https://lastfm-img2.akamaized.net/i/u/300x300/e0bc9ea72a894e37a1efaafaf6a33dd3.jpg";}}}s:5:"@attr";a:5:{s:4:"page";s:1:"1";s:5:"total";s:4:"1004";s:4:"user";s:11:"NecroDoctor";s:7:"perPage";s:1:"1";s:10:"totalPages";s:4:"1004";}}}
EOD;

        $this->client->unsignedCall('library.getArtists', [
            'user'  => 'TheUser',
            'limit' => 50,
            'page'  => 1,
        ])
            ->willReturn(unserialize($rawResponse))
        ;

        $service = new LibraryService($this->client->reveal());
        $result  = $service->getArtists('TheUser');

        static::assertCount(1, $result);
    }
}
