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
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\Chart;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\SongInfo;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Model\User;

final class UserService extends AbstractService
{
    /**
     * Get a list of tracks by a given artist scrobbled by this user, including scrobble time.
     *
     * @param string    $username
     * @param string    $artist
     * @param \DateTime $startTimestamp
     * @param \DateTime $endTimestamp
     * @param int       $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Song[]
     */
    public function getArtistTracks(string $username, string $artist, \DateTime $startTimestamp = null, \DateTime $endTimestamp = null, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getArtistTracks', [
            'user'           => $username,
            'artist'         => $artist,
            'startTimestamp' => $this->toTimestamp($startTimestamp),
            'endTimestamp'   => $this->toTimestamp($endTimestamp),
            'page'           => $page,
        ]);

        if (!isset($response['artisttracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return Song::fromApi($data);
        }, $response['artisttracks']['track']);
    }

    /**
     * Get a list of the user's friends on Last.fm.
     *
     * @param string $username
     * @param bool   $recenttracks
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return User[]
     */
    public function getFriends(string $username, bool $recenttracks = false, $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getFriends', [
            'user'         => $username,
            'recenttracks' => (int) $recenttracks,
            'limit'        => $limit,
            'page'         => $page,
        ]);

        if (!isset($response['friends']['user'])) {
            return [];
        }

        return array_map(function ($data) {
            return User::fromApi($data);
        }, $response['friends']['user']);
    }

    /**
     * Get information about a user profile.
     *
     * @param string $username
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return User|null
     */
    public function getInfo(string $username): ?User
    {
        $response =  $this->unsignedCall('user.getInfo', [
            'user' => $username,
        ]);

        if (!isset($response['user'])) {
            return null;
        }

        return User::fromApi($response['user']);
    }

    /**
     * Get the last 50 tracks loved by a user.
     *
     * @param string $username
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Song[]
     */
    public function getLovedTracks(string $username, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getLovedTracks', [
            'user'  => $username,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['lovedtracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return Song::fromApi($data);
        }, $response['lovedtracks']['track']);
    }

    /**
     * Get a list of the recent tracks listened to by this user. Indicates now playing track if the user is currently listening.
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     * @param bool      $extended
     * @param int       $limit
     * @param int       $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Song[]
     */
    public function getRecentTracks(string $username, \DateTime $from = null, \DateTime $to = null, $extended = false, $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getRecentTracks', [
            'user'     => $username,
            'limit'    => $limit,
            'page'     => $page,
            'extended' => (int) $extended,
            'from'     => $this->toTimestamp($from),
            'to'       => $this->toTimestamp($to),
        ]);

        if (!isset($response['recenttracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return Song::fromApi($data);
        }, $response['recenttracks']['track']);
    }

    /**
     * Get the user's personal tags.
     *
     * @param string $username
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Artist[]
     */
    public function getPersonalTagsForArtist(string $username, string $tag, int $limit = 50, int $page = 1): array
    {
        $response =  $this->unsignedCall('user.getPersonalTags', [
            'taggingtype' => 'artist',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ]);

        if (!isset($response['taggings']['artists']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['taggings']['artists']['artist']);
    }

    /**
     * Get the user's personal tags.
     *
     * @param string $username
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Album[]
     */
    public function getPersonalTagsForAlbum(string $username, string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getPersonalTags', [
            'taggingtype' => 'album',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ]);

        if (!isset($response['taggings']['albums']['album'])) {
            return [];
        }

        return array_map(function ($data) {
            return Album::fromApi($data);
        }, $response['taggings']['albums']['album']);
    }

    /**
     * Get the user's personal tags.
     *
     * @param string $username
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo[]
     */
    public function getPersonalTagsForTracks(string $username, string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getPersonalTags', [
            'taggingtype' => 'track',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ]);

        if (!isset($response['taggings']['tracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return SongInfo::fromApi($data);
        }, $response['taggings']['tracks']['track']);
    }

    /**
     * Get the top albums listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @param string $username
     * @param string $period
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Album[]
     */
    public function getTopAlbums(string $username, string $period = 'overall', int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getTopAlbums', [
            'user'   => $username,
            'period' => $period,
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['topalbums']['album'])) {
            return [];
        }

        return array_map(function ($data) {
            return Album::fromApi($data);
        }, $response['topalbums']['album']);
    }

    /**
     * Get the top artists listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @param string $username
     * @param string $period
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Artist[]
     */
    public function getTopArtists(string $username, string $period = 'overall', int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getTopArtists', [
            'user'   => $username,
            'period' => $period,
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['topartists']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['topartists']['artist']);
    }

    /**
     * Get the top tags used by this user.
     *
     * @param string $username
     * @param int    $limit
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getTopTags(string $username, int $limit = 50): array
    {
        $response = $this->unsignedCall('user.getTopTags', [
            'user'  => $username,
            'limit' => $limit,
        ]);

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * Get the top tracks listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @param string $username
     * @param string $period
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo[]
     */
    public function getTopTracks(string $username, string $period = 'overall', int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('user.getTopTracks', [
            'user'   => $username,
            'period' => $period,
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['toptracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return SongInfo::fromApi($data);
        }, $response['toptracks']['track']);
    }

    /**
     * Get an album chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent album chart for this user.
     *
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Album[]
     */
    public function getWeeklyAlbumChart(string $username, \DateTime $from = null, \DateTime $to = null): array
    {
        $response = $this->unsignedCall('user.getWeeklyAlbumChart', [
            'user' => $username,
            'from' => $this->toTimestamp($from),
            'to'   => $this->toTimestamp($to),
        ]);

        if (!isset($response['weeklyalbumchart']['album'])) {
            return [];
        }

        return array_map(function ($data) {
            return Album::fromApi($data);
        }, $response['weeklyalbumchart']['album']);
    }

    /**
     * Get an artist chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent artist chart for this user.
     *
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Artist[]
     */
    public function getWeeklyArtistChart(string $username, \DateTime $from = null, \DateTime $to = null): array
    {
        $response = $this->unsignedCall('user.getWeeklyArtistChart', [
            'user' => $username,
            'from' => $this->toTimestamp($from),
            'to'   => $this->toTimestamp($to),
        ]);

        if (!isset($response['weeklyartistchart']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['weeklyartistchart']['artist']);
    }

    /**
     * Get a list of available charts for this user, expressed as date ranges which can be sent to the chart services.
     *
     * @param string $username
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Chart[]
     */
    public function getWeeklyChartList(string $username): array
    {
        $response = $this->unsignedCall('user.getWeeklyChartList', [
            'user' => $username,
        ]);

        if (!isset($response['weeklychartlist']['chart'])) {
            return [];
        }

        return array_map(function ($data) {
            return Chart::fromApi($data);
        }, $response['weeklychartlist']['chart']);
    }

    /**
     * Get a track chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent track chart for this user.
     *
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo[]
     */
    public function getWeeklyTrackChart(string $username, \DateTime $from = null, \DateTime $to = null): array
    {
        $response = $this->unsignedCall('user.getWeeklyTrackChart', [
            'user' => $username,
            'from' => $this->toTimestamp($from),
            'to'   => $this->toTimestamp($to),
        ]);

        if (!isset($response['weeklytrackchart']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return SongInfo::fromApi($data);
        }, $response['weeklytrackchart']['track']);
    }
}
