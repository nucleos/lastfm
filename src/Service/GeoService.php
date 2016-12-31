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

final class GeoService extends AbstractService
{
    /**
     * Get the most popular artists on Last.fm by country.
     *
     * @param string $country
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopArtists($country, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('geo.getTopArtists', array(
            'country' => $country,
            'limit' => $limit,
            'page' => $page,
        ));
    }

    /**
     * Get the most popular tracks on Last.fm last week by country.
     *
     * @param string $country
     * @param string $location
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopTracks($country, $location = null, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('geo.getTopTracks', array(
            'country' => $country,
            'location' => $location,
            'limit' => $limit,
            'page' => $page,
        ));
    }
}
