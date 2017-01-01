<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Exception\ApiException;

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
     */
    public function getInfo($tag, $lang = null)
    {
        return $this->connection->unsignedCall('tag.getInfo', array(
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
     */
    public function getSimilar($tag)
    {
        return $this->connection->unsignedCall('tag.getSimilar', array(
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
     */
    public function getTopAlbums($tag, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('tag.getTopAlbums', array(
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
     */
    public function getTopArtists($tag, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('tag.getTopArtists', array(
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
     */
    public function getTopTags()
    {
        return $this->connection->unsignedCall('tag.getTopTags');
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
     */
    public function getTopTracks($tag, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('tag.getTopTracks', array(
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
     */
    public function getWeeklyChartList($tag)
    {
        return $this->connection->unsignedCall('tag.getWeeklyChartList', array(
            'tag' => $tag,
        ));
    }
}
