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
use Nucleos\LastFm\Model\ArtistInfo;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\Tag;

interface ChartServiceInterface
{
    /**
     * Get the most popular artists on Last.fm.
     *
     * @return ArtistInfo[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopArtists(int $limit = 50, int $page = 1): array;

    /**
     * Get the most popular tags on Last.fm last week.
     *
     * @return Tag[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopTags(int $limit = 50, int $page = 1): array;

    /**
     * Get the most popular tracks on Last.fm last week.
     *
     * @return Song[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopTracks(int $limit = 50, int $page = 1): array;
}
