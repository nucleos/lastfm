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

final class LibraryService extends AbstractService
{
    /**
     * A paginated list of all the artists in a user's library, with play counts and tag counts.
     *
     * @param string $user
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getArtists($user, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('library.getArtists', array(
            'user'  => $user,
            'limit' => $limit,
            'page'  => $page,
        ));
    }
}
