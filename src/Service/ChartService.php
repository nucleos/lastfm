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

final class ChartService extends AbstractService
{
    /**
     * Get the most popular artists on Last.fm.
     *
     * @param int $limit
     * @param int $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopArtists($limit = 50, $page = 1)
    {
        return $this->unsignedCall('chart.getTopArtists', array(
            'limit' => $limit,
            'page'  => $page,
        ));
    }

    /**
     * Get the most popular tags on Last.fm last week.
     *
     * @param int $limit
     * @param int $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTags($limit = 50, $page = 1)
    {
        return $this->unsignedCall('chart.getTopTags', array(
            'limit' => $limit,
            'page'  => $page,
        ));
    }

    /**
     * Get the most popular tracks on Last.fm last week.
     *
     * @param int $limit
     * @param int $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTracks($limit = 50, $page = 1)
    {
        return $this->unsignedCall('chart.getTopTracks', array(
            'limit' => $limit,
            'page'  => $page,
        ));
    }
}
