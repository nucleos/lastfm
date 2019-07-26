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
use Core23\LastFm\Model\ArtistInfo;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Util\ApiHelper;

final class ChartService implements ChartServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    public function getTopArtists(int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('chart.getTopArtists', [
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['artists']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return ArtistInfo::fromApi($data);
            },
            $response['artists']['artist']
        );
    }

    public function getTopTags(int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('chart.getTopTags', [
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Tag::fromApi($data);
            },
            $response['tags']['tag']
        );
    }

    public function getTopTracks(int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('chart.getTopTracks', [
            'limit' => $limit,
            'page'  => $page,
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
