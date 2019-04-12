<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Client\ApiClientInterface;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Util\ApiHelper;

final class GeoService implements GeoServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    /**
     * @param ApiClientInterface $client
     */
    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getTopArtists(string $country, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('geo.getTopArtists', [
            'country' => $country,
            'limit'   => $limit,
            'page'    => $page,
        ]);

        if (!isset($response['topartists']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Artist::fromApi($data);
            },
            $response['topartists']['artist']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTopTracks(string $country, string $location = null, $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('geo.getTopTracks', [
            'country'  => $country,
            'location' => $location,
            'limit'    => $limit,
            'page'     => $page,
        ]);

        if (!isset($response['tracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Song::fromApi($data);
            },
            $response['tracks']['track']
        );
    }
}
