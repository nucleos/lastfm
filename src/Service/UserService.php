<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Client\ApiClientInterface;
use Core23\LastFm\Filter\Period;
use Core23\LastFm\Filter\RangeFilter;
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\Chart;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\SongInfo;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Model\User;
use Core23\LastFm\Util\ApiHelper;

final class UserService implements UserServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    public function getArtistTracks(string $username, string $artist, ?RangeFilter $filter = null, int $page = 1): array
    {
        $query = null !== $filter ? $filter->getQuery('startTimestamp', 'endTimestamp') : [];
        $query = array_merge($query, [
            'user'           => $username,
            'artist'         => $artist,
            'page'           => $page,
        ]);

        $response = $this->client->unsignedCall('user.getArtistTracks', $query);

        if (!isset($response['artisttracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Song::fromApi($data);
            },
            $response['artisttracks']['track']
        );
    }

    public function getFriends(string $username, bool $recenttracks = false, $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('user.getFriends', [
            'user'         => $username,
            'recenttracks' => (int) $recenttracks,
            'limit'        => $limit,
            'page'         => $page,
        ]);

        if (!isset($response['friends']['user'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return User::fromApi($data);
            },
            $response['friends']['user']
        );
    }

    public function getInfo(string $username): ?User
    {
        $response =  $this->client->unsignedCall('user.getInfo', [
            'user' => $username,
        ]);

        if (!isset($response['user'])) {
            return null;
        }

        return User::fromApi($response['user']);
    }

    public function getLovedTracks(string $username, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('user.getLovedTracks', [
            'user'  => $username,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['lovedtracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Song::fromApi($data);
            },
            $response['lovedtracks']['track']
        );
    }

    public function getRecentTracks(string $username, ?RangeFilter $filter = null, $extended = false, $limit = 50, int $page = 1): array
    {
        $query = null !== $filter ? $filter->getQuery('from', 'to') : [];
        $query = array_merge($query, [
            'user'     => $username,
            'limit'    => $limit,
            'page'     => $page,
            'extended' => (int) $extended,
        ]);

        $response = $this->client->unsignedCall('user.getRecentTracks', $query);

        if (!isset($response['recenttracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Song::fromApi($data);
            },
            $response['recenttracks']['track']
        );
    }

    public function getPersonalTagsForArtist(string $username, string $tag, int $limit = 50, int $page = 1): array
    {
        $response =  $this->client->unsignedCall('user.getPersonalTags', [
            'taggingtype' => 'artist',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ]);

        if (!isset($response['taggings']['artists']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Artist::fromApi($data);
            },
            $response['taggings']['artists']['artist']
        );
    }

    public function getPersonalTagsForAlbum(string $username, string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('user.getPersonalTags', [
            'taggingtype' => 'album',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ]);

        if (!isset($response['taggings']['albums']['album'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Album::fromApi($data);
            },
            $response['taggings']['albums']['album']
        );
    }

    public function getPersonalTagsForTracks(string $username, string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('user.getPersonalTags', [
            'taggingtype' => 'track',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ]);

        if (!isset($response['taggings']['tracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return SongInfo::fromApi($data);
            },
            $response['taggings']['tracks']['track']
        );
    }

    public function getTopAlbums(string $username, Period $period, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('user.getTopAlbums', [
            'user'   => $username,
            'period' => $period->getValue(),
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['topalbums']['album'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Album::fromApi($data);
            },
            $response['topalbums']['album']
        );
    }

    public function getTopArtists(string $username, Period $period, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('user.getTopArtists', [
            'user'   => $username,
            'period' => $period->getValue(),
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['topartists']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Artist::fromApi($data);
            },
            $response['topartists']['artist']
        );
    }

    public function getTopTags(string $username, int $limit = 50): array
    {
        $response = $this->client->unsignedCall('user.getTopTags', [
            'user'  => $username,
            'limit' => $limit,
        ]);

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Tag::fromApi($data);
            },
            $response['toptags']['tag']
        );
    }

    public function getTopTracks(string $username, Period $period, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('user.getTopTracks', [
            'user'   => $username,
            'period' => $period->getValue(),
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['toptracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return SongInfo::fromApi($data);
            },
            $response['toptracks']['track']
        );
    }

    public function getWeeklyAlbumChart(string $username, ?RangeFilter $filter = null): array
    {
        $query = null !== $filter ? $filter->getQuery('from', 'to') : [];
        $query = array_merge($query, [
            'user'     => $username,
        ]);

        $response = $this->client->unsignedCall('user.getWeeklyAlbumChart', $query);

        if (!isset($response['weeklyalbumchart']['album'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Album::fromApi($data);
            },
            $response['weeklyalbumchart']['album']
        );
    }

    public function getWeeklyArtistChart(string $username, ?RangeFilter $filter = null): array
    {
        $query = null !== $filter ? $filter->getQuery('from', 'to') : [];
        $query = array_merge($query, [
            'user'     => $username,
        ]);

        $response = $this->client->unsignedCall('user.getWeeklyArtistChart', $query);

        if (!isset($response['weeklyartistchart']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Artist::fromApi($data);
            },
            $response['weeklyartistchart']['artist']
        );
    }

    public function getWeeklyChartList(string $username): array
    {
        $response = $this->client->unsignedCall('user.getWeeklyChartList', [
            'user' => $username,
        ]);

        if (!isset($response['weeklychartlist']['chart'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Chart::fromApi($data);
            },
            $response['weeklychartlist']['chart']
        );
    }

    public function getWeeklyTrackChart(string $username, ?RangeFilter $filter = null): array
    {
        $query = null !== $filter ? $filter->getQuery('from', 'to') : [];
        $query = array_merge($query, [
            'user'     => $username,
        ]);

        $response = $this->client->unsignedCall('user.getWeeklyTrackChart', $query);

        if (!isset($response['weeklytrackchart']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return SongInfo::fromApi($data);
            },
            $response['weeklytrackchart']['track']
        );
    }
}
