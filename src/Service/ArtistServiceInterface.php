<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Connection\SessionInterface;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\ArtistInfo;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;
use InvalidArgumentException;

interface ArtistServiceInterface
{
    /**
     * Tag an artist using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string[]         $tags
     *
     * @throws InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, array $tags): void;

    /**
     * Check whether the supplied artist has a correction to a canonical artist.
     *
     * @param string $artist
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist|null
     */
    public function getCorrection(string $artist): ?Artist;

    /**
     * Get the metadata for an artist on Last.fm. Includes biography.
     *
     * @param string $artist
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return ArtistInfo|null
     */
    public function getInfo(string $artist): ?ArtistInfo;

    /**
     * Get all the artists similar to this artist.
     *
     * @param string $artist
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist[]
     */
    public function getSimilar(string $artist, int $limit = 50, bool $autocorrect = false): array;

    /**
     * Get all the artists similar to this artist using musicbrainz id.
     *
     * @param string $mbid
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist[]
     */
    public function getSimilarByMBID(string $mbid, int $limit = 50, bool $autocorrect = false): array;

    /**
     * Get the tags applied by an individual user to an artist on Last.fm.
     *
     * @param string $artist
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTags(string $artist, string $username, bool $autocorrect = false): array;

    /**
     * Get the tags applied by an individual user to an artist using musicbrainz id on Last.fm.
     *
     * @param string $mbid
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTagsByMBID(string $mbid, string $username, bool $autocorrect = false): array;

    /**
     * Get the top albums for an artist on Last.fm, ordered by popularity.
     *
     * @param string $artist
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Album[]
     */
    public function getTopAlbums(string $artist, int $page = 1, int $limit = 10, bool $autocorrect = false): array;

    /**
     * Get the top albums for an artist using musicbrainz id on Last.fm, ordered by popularity.
     *
     * @param string $mbid
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Album[]
     */
    public function getTopAlbumsByMBID(string $mbid, int $page = 1, int $limit = 10, bool $autocorrect = false): array;

    /**
     * Get the top tags for an artist on Last.fm, ordered by popularity.
     *
     * @param string $artist
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTags(string $artist, bool $autocorrect = false): array;

    /**
     * Get the top tags for an artist on Last.fm using musicbrainz id, ordered by popularity.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTagsByMBID(string $mbid, bool $autocorrect = false): array;

    /**
     * Get the top tracks by an artist on Last.fm, ordered by popularity.
     *
     * @param string $artist
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Song[]
     */
    public function getTopTracks(string $artist, int $page = 1, int $limit = 10, bool $autocorrect = false): array;

    /**
     * Get the top tracks by an artist on Last.fm using musicbrainz id, ordered by popularity.
     *
     * @param string $mbid
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Song[]
     */
    public function getTopTracksByMBID(string $mbid, int $page = 1, int $limit = 10, bool $autocorrect = false): array;

    /**
     * Remove a user's tag from an artist.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $tag
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, string $artist, string $tag): void;

    /**
     * Search for an artist by name. Returns artist matches sorted by relevance.
     *
     * @param string $artist
     * @param int    $limit
     * @param int    $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist[]
     */
    public function search(string $artist, int $limit = 50, int $page = 1): array;
}
