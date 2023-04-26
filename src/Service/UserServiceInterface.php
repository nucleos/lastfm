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
use Nucleos\LastFm\Filter\Period;
use Nucleos\LastFm\Filter\RangeFilter;
use Nucleos\LastFm\Model\Album;
use Nucleos\LastFm\Model\Artist;
use Nucleos\LastFm\Model\Chart;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\SongInfo;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Model\User;

interface UserServiceInterface
{
    /**
     * Get a list of tracks by a given artist scrobbled by this user, including scrobble time.
     *
     * @return Song[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getArtistTracks(string $username, string $artist, ?RangeFilter $filter = null, int $page = 1): array;

    /**
     * Get a list of the user's friends on Last.fm.
     *
     * @param int $limit
     *
     * @return User[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getFriends(string $username, bool $recenttracks = false, $limit = 50, int $page = 1): array;

    /**
     * Get information about a user profile.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getInfo(string $username): ?User;

    /**
     * Get the last 50 tracks loved by a user.
     *
     * @return Song[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getLovedTracks(string $username, int $limit = 50, int $page = 1): array;

    /**
     * Get a list of the recent tracks listened to by this user. Indicates now playing track if the user is currently listening.
     *
     * @param bool $extended
     * @param int  $limit
     *
     * @return Song[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getRecentTracks(string $username, ?RangeFilter $filter = null, $extended = false, $limit = 50, int $page = 1): array;

    /**
     * Get the user's personal tags.
     *
     * @return Artist[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getPersonalTagsForArtist(string $username, string $tag, int $limit = 50, int $page = 1): array;

    /**
     * Get the user's personal tags.
     *
     * @return Album[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getPersonalTagsForAlbum(string $username, string $tag, int $limit = 50, int $page = 1): array;

    /**
     * Get the user's personal tags.
     *
     * @return SongInfo[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getPersonalTagsForTracks(string $username, string $tag, int $limit = 50, int $page = 1): array;

    /**
     * Get the top albums listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @return Album[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopAlbums(string $username, Period $period, int $limit = 50, int $page = 1): array;

    /**
     * Get the top artists listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @return Artist[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopArtists(string $username, Period $period, int $limit = 50, int $page = 1): array;

    /**
     * Get the top tags used by this user.
     *
     * @return Tag[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopTags(string $username, int $limit = 50): array;

    /**
     * Get the top tracks listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @return SongInfo[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopTracks(string $username, Period $period, int $limit = 50, int $page = 1): array;

    /**
     * Get an album chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent album chart for this user.
     *
     * @return Album[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getWeeklyAlbumChart(string $username, ?RangeFilter $filter = null): array;

    /**
     * Get an artist chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent artist chart for this user.
     *
     * @return Artist[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getWeeklyArtistChart(string $username, ?RangeFilter $filter = null): array;

    /**
     * Get a list of available charts for this user, expressed as date ranges which can be sent to the chart services.
     *
     * @return Chart[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getWeeklyChartList(string $username): array;

    /**
     * Get a track chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent track chart for this user.
     *
     * @return SongInfo[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getWeeklyTrackChart(string $username, ?RangeFilter $filter = null): array;
}
