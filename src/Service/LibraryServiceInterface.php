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
use Core23\LastFm\Model\AlbumInfo;

interface LibraryServiceInterface
{
    /**
     * A paginated list of all the artists in a user's library, with play counts and tag counts.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return AlbumInfo[]
     */
    public function getArtists(string $user, int $limit = 50, int $page = 1): array;
}
