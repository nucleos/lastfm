<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Service;

use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Service\GeoService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GeoServiceTest extends TestCase
{
    /**
     * @var ApiClientInterface&MockObject
     */
    private ApiClientInterface $client;

    protected function setUp(): void
    {
        $this->client =  $this->createMock(ApiClientInterface::class);
    }

    public function testGetTopArtists(): void
    {
        $rawResponse = <<<'EOD'
a:1:{s:10:"topartists";a:2:{s:6:"artist";a:1:{i:0;a:6:{s:4:"name";s:8:"Coldplay";s:9:"listeners";s:7:"5381410";s:4:"mbid";s:36:"cc197bad-dc9c-440d-a5b5-d52ba2e14234";s:3:"url";s:34:"https://www.last.fm/music/Coldplay";s:10:"streamable";s:1:"0";s:5:"image";a:5:{i:0;a:2:{s:5:"#text";s:78:"https://lastfm-img2.akamaized.net/i/u/34s/5bdb5d4c53504627c62f9e30f48e9063.png";s:4:"size";s:5:"small";}i:1;a:2:{s:5:"#text";s:78:"https://lastfm-img2.akamaized.net/i/u/64s/5bdb5d4c53504627c62f9e30f48e9063.png";s:4:"size";s:6:"medium";}i:2;a:2:{s:5:"#text";s:79:"https://lastfm-img2.akamaized.net/i/u/174s/5bdb5d4c53504627c62f9e30f48e9063.png";s:4:"size";s:5:"large";}i:3;a:2:{s:5:"#text";s:82:"https://lastfm-img2.akamaized.net/i/u/300x300/5bdb5d4c53504627c62f9e30f48e9063.png";s:4:"size";s:10:"extralarge";}i:4;a:2:{s:5:"#text";s:82:"https://lastfm-img2.akamaized.net/i/u/300x300/5bdb5d4c53504627c62f9e30f48e9063.png";s:4:"size";s:4:"mega";}}}}s:5:"@attr";a:5:{s:7:"country";s:7:"Germany";s:4:"page";s:1:"1";s:7:"perPage";s:1:"1";s:10:"totalPages";s:7:"1125116";s:5:"total";s:7:"1125116";}}}
EOD;

        $this->client->method('unsignedCall')->with('geo.getTopArtists', [
            'country'  => 'France',
            'limit'    => 50,
            'page'     => 1,
        ])
            ->willReturn(unserialize($rawResponse))
        ;

        $service = new GeoService($this->client);
        $result  = $service->getTopArtists('France');

        self::assertCount(1, $result);
    }

    public function testGetTopTracks(): void
    {
        $rawResponse = <<<'EOD'
a:1:{s:6:"tracks";a:2:{s:5:"track";a:1:{i:0;a:9:{s:4:"name";s:23:"Smells Like Teen Spirit";s:8:"duration";s:3:"301";s:9:"listeners";s:7:"2065226";s:4:"mbid";s:36:"0ebe2d92-a11d-4b2b-9922-806383074ed7";s:3:"url";s:59:"https://www.last.fm/music/Nirvana/_/Smells+Like+Teen+Spirit";s:10:"streamable";a:2:{s:5:"#text";s:1:"0";s:9:"fulltrack";s:1:"0";}s:6:"artist";a:3:{s:4:"name";s:7:"Nirvana";s:4:"mbid";s:36:"9282c8b4-ca0b-4c6b-b7e3-4f7762dfc4d6";s:3:"url";s:33:"https://www.last.fm/music/Nirvana";}s:5:"image";a:4:{i:0;a:2:{s:5:"#text";s:78:"https://lastfm-img2.akamaized.net/i/u/34s/5e5d836721e245d59946d38acb6d81d8.png";s:4:"size";s:5:"small";}i:1;a:2:{s:5:"#text";s:78:"https://lastfm-img2.akamaized.net/i/u/64s/5e5d836721e245d59946d38acb6d81d8.png";s:4:"size";s:6:"medium";}i:2;a:2:{s:5:"#text";s:79:"https://lastfm-img2.akamaized.net/i/u/174s/5e5d836721e245d59946d38acb6d81d8.png";s:4:"size";s:5:"large";}i:3;a:2:{s:5:"#text";s:82:"https://lastfm-img2.akamaized.net/i/u/300x300/5e5d836721e245d59946d38acb6d81d8.png";s:4:"size";s:10:"extralarge";}}s:5:"@attr";a:1:{s:4:"rank";s:1:"0";}}}s:5:"@attr";a:5:{s:7:"country";s:7:"Germany";s:4:"page";s:1:"1";s:7:"perPage";s:1:"1";s:10:"totalPages";s:8:"10183259";s:5:"total";s:8:"10183259";}}}
EOD;

        $this->client->method('unsignedCall')->with('geo.getTopTracks', [
            'country'  => 'France',
            'location' => null,
            'limit'    => 50,
            'page'     => 1,
        ])
            ->willReturn(unserialize($rawResponse))
        ;

        $service = new GeoService($this->client);
        $result  = $service->getTopTracks('France');

        self::assertCount(1, $result);
    }
}
