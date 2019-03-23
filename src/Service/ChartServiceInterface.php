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
use Core23\LastFm\Model\ArtistInfo;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;

interface ChartServiceInterface
{
    /**
     * Get the most popular artists on Last.fm.
     *
     * @param int $limit
     * @param int $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return ArtistInfo[]
     */
    public function getTopArtists(int $limit = 50, int $page = 1): array;

    /**
     * Get the most popular tags on Last.fm last week.
     *
     * @param int $limit
     * @param int $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTags(int $limit = 50, int $page = 1): array;

    /**
     * Get the most popular tracks on Last.fm last week.
     *
     * @param int $limit
     * @param int $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Song[]
     */
    public function getTopTracks(int $limit = 50, int $page = 1): array;
}
