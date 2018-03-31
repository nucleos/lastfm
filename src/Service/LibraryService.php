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
use Core23\LastFm\Model\AlbumInfo;
use Core23\LastFm\Model\ArtistInfo;

final class LibraryService extends AbstractService
{
    /**
     * A paginated list of all the artists in a user's library, with play counts and tag counts.
     *
     * @param string $user
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return AlbumInfo[]
     */
    public function getArtists(string $user, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('library.getArtists', [
            'user'  => $user,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['artists']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return ArtistInfo::fromApi($data);
        }, $response['artists']['artist']);
    }
}
