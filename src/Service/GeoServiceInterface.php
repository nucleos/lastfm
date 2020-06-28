<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Service;

use Nucleos\LastFm\Exception\ApiException;
use Nucleos\LastFm\Exception\NotFoundException;
use Nucleos\LastFm\Model\Artist;
use Nucleos\LastFm\Model\Song;

interface GeoServiceInterface
{
    /**
     * Get the most popular artists on Last.fm by country.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist[]
     */
    public function getTopArtists(string $country, int $limit = 50, int $page = 1): array;

    /**
     * Get the most popular tracks on Last.fm last week by country.
     *
     * @param string $location
     * @param int    $limit
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Song[]
     */
    public function getTopTracks(string $country, string $location = null, $limit = 50, int $page = 1): array;
}
