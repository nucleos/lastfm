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
use Nucleos\LastFm\Model\AlbumInfo;

interface LibraryServiceInterface
{
    /**
     * A paginated list of all the artists in a user's library, with play counts and tag counts.
     *
     * @return AlbumInfo[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getArtists(string $user, int $limit = 50, int $page = 1): array;
}
