<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;

final class TagService extends AbstractService
{
    /**
     * Get the metadata for a tag on Last.fm. Includes biography.
     *
     * @param string $tag
     * @param string $lang
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getInfo(string $tag, string $lang = null): array
    {
        return $this->unsignedCall('tag.getInfo', array(
            'tag'  => $tag,
            'lang' => $lang,
        ));
    }

    /**
     * Search for tags similar to this one. Returns tags ranked by similarity, based on listening data.
     *
     * @param string $tag
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getSimilar($tag): array
    {
        return $this->unsignedCall('tag.getSimilar', array(
            'tag' => $tag,
        ));
    }

    /**
     * Get the top albums tagged by this tag, ordered by tag count.
     *
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopAlbums(string $tag, int $limit = 50, int $page = 1): array
    {
        return $this->unsignedCall('tag.getTopAlbums', array(
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
        ));
    }

    /**
     * Get the top artists tagged by this tag, ordered by tag count.
     *
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopArtists(string $tag, int $limit = 50, int $page = 1): array
    {
        return $this->unsignedCall('tag.getTopArtists', array(
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
        ));
    }

    /**
     * Fetches the top global tags on Last.fm, sorted by popularity (number of times used).
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTags(): array
    {
        return $this->unsignedCall('tag.getTopTags');
    }

    /**
     * Get the top tracks tagged by this tag, ordered by tag count.
     *
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTracks(string $tag, int $limit = 50, int $page = 1): array
    {
        return $this->unsignedCall('tag.getTopTracks', array(
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
        ));
    }

    /**
     * Get a list of available charts for this tag, expressed as date ranges which can be sent to the chart services.
     *
     * @param string $tag
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getWeeklyChartList(string $tag): array
    {
        return $this->unsignedCall('tag.getWeeklyChartList', array(
            'tag' => $tag,
        ));
    }
}
