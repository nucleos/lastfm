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
     * @return array
     */
    public function getTopArtists(int $limit = 50, int $page = 1): array
    {
        return $this->unsignedCall('chart.getTopArtists', [
            'limit' => $limit,
            'page'  => $page,
        ]);
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
     * @return array
     */
    public function getTopTags(int $limit = 50, int $page = 1): array
    {
        return $this->unsignedCall('chart.getTopTags', [
            'limit' => $limit,
            'page'  => $page,
        ]);
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
     * @return array
     */
    public function getTopTracks(int $limit = 50, int $page = 1): array
    {
        return $this->unsignedCall('chart.getTopTracks', [
            'limit' => $limit,
            'page'  => $page,
        ]);
    }
}
