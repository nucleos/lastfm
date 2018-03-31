<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;
use Core23\LastFm\Model\ArtistInfo;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;

final class ChartService extends AbstractService
{
    /**
     * Get the most popular artists on Last.fm.
     *
     * @param int $limit
     * @param int $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return ArtistInfo[]
     */
    public function getTopArtists(int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('chart.getTopArtists', [
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['artists']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return ArtistInfo::fromApi($data);
        }, $response['artists']['artist']);
    }

    /**
     * Get the most popular tags on Last.fm last week.
     *
     * @param int $limit
     * @param int $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getTopTags(int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('chart.getTopTags', [
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['tags']['tag']);
    }

    /**
     * Get the most popular tracks on Last.fm last week.
     *
     * @param int $limit
     * @param int $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Song[]
     */
    public function getTopTracks(int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('chart.getTopTracks', [
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['tracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return Song::fromApi($data);
        }, $response['tracks']['track']);
    }
}
