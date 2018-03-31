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
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\Chart;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Model\TagInfo;

final class TagService extends AbstractService
{
    /**
     * Get the metadata for a tag on Last.fm. Includes biography.
     *
     * @param string $tag
     * @param string $lang
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return TagInfo|null
     */
    public function getInfo(string $tag, string $lang = null): ?TagInfo
    {
        $response = $this->unsignedCall('tag.getInfo', [
            'tag'  => $tag,
            'lang' => $lang,
        ]);

        if (!isset($response['tag'])) {
            return null;
        }

        return TagInfo::fromApi($response['tag']);
    }

    /**
     * Search for tags similar to this one. Returns tags ranked by similarity, based on listening data.
     *
     * @param string $tag
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getSimilar(string $tag): array
    {
        $response = $this->unsignedCall('tag.getSimilar', [
            'tag' => $tag,
        ]);

        if (!isset($response['similartags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['similartags']['tag']);
    }

    /**
     * Get the top albums tagged by this tag, ordered by tag count.
     *
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Album[]
     */
    public function getTopAlbums(string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('tag.getTopAlbums', [
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['albums']['album'])) {
            return [];
        }

        return array_map(function ($data) {
            return Album::fromApi($data);
        }, $response['albums']['album']);
    }

    /**
     * Get the top artists tagged by this tag, ordered by tag count.
     *
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Artist[]
     */
    public function getTopArtists(string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('tag.getTopArtists', [
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['topartists']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['topartists']['artist']);
    }

    /**
     * Fetches the top global tags on Last.fm, sorted by popularity (number of times used).
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getTopTags(): array
    {
        $response = $this->unsignedCall('tag.getTopTags');

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * Get the top tracks tagged by this tag, ordered by tag count.
     *
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Song[]
     */
    public function getTopTracks(string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('tag.getTopTracks', [
            'tag'   => $tag,
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

    /**
     * Get a list of available charts for this tag, expressed as date ranges which can be sent to the chart services.
     *
     * @param string $tag
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Chart[]
     */
    public function getWeeklyChartList(string $tag): array
    {
        $response = $this->unsignedCall('tag.getWeeklyChartList', [
            'tag' => $tag,
        ]);

        if (!isset($response['weeklychartlist']['chart'])) {
            return [];
        }

        return array_map(function ($data) {
            return Chart::fromApi($data);
        }, $response['weeklychartlist']['chart']);
    }
}
