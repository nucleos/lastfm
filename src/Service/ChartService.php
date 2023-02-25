<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Service;

use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Model\ArtistInfo;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Util\ApiHelper;

final class ChartService implements ChartServiceInterface
{
    private ApiClientInterface $client;

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
            static function (array $data): ArtistInfo {
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
            static function (array $data): Tag {
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
            static function (array $data): Song {
                return Song::fromApi($data);
            },
            $response['tracks']['track']
        );
    }
}
