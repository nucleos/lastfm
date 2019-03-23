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
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\AlbumInfo;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Session\SessionInterface;
use InvalidArgumentException;

interface AlbumServiceInterface
{
    /**
     * Tag an album using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $album
     * @param string[]         $tags
     *
     * @throws InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, string $album, array $tags): void;

    /**
     * Get the metadata for an album on Last.fm using the musicbrainz id.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     * @param string $username
     * @param string $lang
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return AlbumInfo
     */
    public function getInfoByMBID(
        string $mbid,
        bool $autocorrect = false,
        ?string $username = null,
        $lang = null
    ): AlbumInfo;

    /**
     * Get the metadata for an album on Last.fm using the album name.
     *
     * @param string $artist
     * @param string $album
     * @param bool   $autocorrect
     * @param string $username
     * @param string $lang
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return AlbumInfo
     */
    public function getInfo(
        string $artist,
        string $album,
        bool $autocorrect = false,
        ?string $username = null,
        ?string $lang = null
    ): AlbumInfo;

    /**
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @param string $artist
     * @param string $album
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return AlbumInfo[]
     */
    public function getTags(string $artist, string $album, string $username, bool $autocorrect = false): array;

    /**
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @param string $mbid
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return AlbumInfo[]
     */
    public function getTagsByMBID(string $mbid, string $username, bool $autocorrect = false): array;

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @param string $artist
     * @param string $album
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTags(string $artist, string $album, bool $autocorrect = false): array;

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return AlbumInfo[]
     */
    public function getTopTagsByMBID(string $mbid, bool $autocorrect = false): array;

    /**
     * Remove a user's tag from an album.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $album
     * @param string           $tag
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, string $artist, string $album, string $tag): void;

    /**
     * Search for an album by name. Returns album matches sorted by relevance.
     *
     * @param string $album
     * @param int    $limit
     * @param int    $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Album[]
     */
    public function search(string $album, int $limit = 50, int $page = 1): array;
}
