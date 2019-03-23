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
use Core23\LastFm\Model\NowPlaying;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\SongInfo;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Session\SessionInterface;

interface TrackServiceInterface
{
    /**
     * Tag an track using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     * @param array            $tags
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, string $track, array $tags): void;

    /**
     * Check whether the supplied track has a correction to a canonical artist.
     *
     * @param string $artist
     * @param string $track
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Song|null
     */
    public function getCorrection(string $artist, string $track): ?Song;

    /**
     * Get the metadata for a track on Last.fm using the artist/track name.
     *
     * @param string      $artist
     * @param string      $track
     * @param string|null $username
     * @param bool        $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return SongInfo|null
     */
    public function getInfo(string $artist, string $track, ?string $username = null, $autocorrect = false): ?SongInfo;

    /**
     * Get the metadata for a track on Last.fm using the musicbrainz id.
     *
     * @param string      $mbid
     * @param string|null $username
     * @param bool        $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return SongInfo|null
     */
    public function getInfoByMBID(string $mbid, ?string $username = null, $autocorrect = false): ?SongInfo;

    /**
     * Get the similar tracks for this track on Last.fm, based on listening data.
     *
     * @param string $artist
     * @param string $track
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return SongInfo[]
     */
    public function getSimilar(string $artist, string $track, int $limit = 10, bool $autocorrect = false): array;

    /**
     * Get the similar tracks for this track using the musicbrainz id on Last.fm, based on listening data.
     *
     * @param string $mbid
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return SongInfo[]
     */
    public function getSimilarByMBID(string $mbid, int $limit = 10, bool $autocorrect = false): array;

    /**
     * Get the tags applied by an individual user to a track on Last.fm.
     *
     * @param string $artist
     * @param string $track
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTags(string $artist, string $track, string $username, bool $autocorrect = false): array;

    /**
     * Get the tags applied by an individual user to a track using the musicbrainz id on Last.fm.
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
     * Get the top tags for this track on Last.fm, ordered by tag count.
     *
     * @param string $artist
     * @param string $track
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTags(string $artist, string $track, bool $autocorrect = false): array;

    /**
     * Get the top tags for this track using the musicbrainz id on Last.fm, ordered by tag count.
     *
     * @param string $bdid
     * @param bool   $autocorrect
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTagsByMBID(string $bdid, bool $autocorrect = false): array;

    /**
     * Love a track for a user profile.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function love(SessionInterface $session, string $artist, string $track): void;

    /**
     * Remove a user's tag from a track.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     * @param string           $tag
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, string $artist, string $track, string $tag): void;

    /**
     * Share a track twith one or more Last.fm users or other friends.
     *
     * @param SessionInterface $session
     * @param array            $tracks
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function scrobble(SessionInterface $session, array $tracks): void;

    /**
     * Search for a track by track name. Returns track matches sorted by relevance.
     *
     * @param string $track
     * @param int    $limit
     * @param int    $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return SongInfo[]
     */
    public function search(string $track, int $limit = 50, int $page = 1): array;

    /**
     * Unlove a track for a user profile.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function unlove(SessionInterface $session, string $artist, string $track): void;

    /**
     * Share a track twith one or more Last.fm users or other friends.
     *
     * @param SessionInterface $session
     * @param NowPlaying       $nowPlaying
     */
    public function updateNowPlaying(SessionInterface $session, NowPlaying $nowPlaying): void;
}
