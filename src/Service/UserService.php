<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Service;

use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Filter\Period;
use Nucleos\LastFm\Filter\RangeFilter;
use Nucleos\LastFm\Model\Album;
use Nucleos\LastFm\Model\Artist;
use Nucleos\LastFm\Model\Chart;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\SongInfo;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Model\User;
use Nucleos\LastFm\Util\ApiHelper;

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
            static function (array $data): Song {
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
            static function (array $data): User {
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
            static function (array $data): Song {
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
            static function (array $data): Song {
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
            static function (array $data): Artist {
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
            static function (array $data): Album {
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
            static function (array $data): SongInfo {
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
            static function (array $data): Album {
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
            static function (array $data): Artist {
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
            static function (array $data): Tag {
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
            static function (array $data): SongInfo {
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
            static function (array $data): Album {
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
            static function (array $data): Artist {
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
            static function (array $data): Chart {
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
            static function (array $data): SongInfo {
                return SongInfo::fromApi($data);
            },
            $response['weeklytrackchart']['track']
        );
    }
}
