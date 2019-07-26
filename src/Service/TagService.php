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
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\Chart;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Model\TagInfo;
use Core23\LastFm\Util\ApiHelper;

final class TagService implements TagServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo(string $tag, string $lang = null): ?TagInfo
    {
        $response = $this->client->unsignedCall('tag.getInfo', [
            'tag'  => $tag,
            'lang' => $lang,
        ]);

        if (!isset($response['tag'])) {
            return null;
        }

        return TagInfo::fromApi($response['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getSimilar(string $tag): array
    {
        $response = $this->client->unsignedCall('tag.getSimilar', [
            'tag' => $tag,
        ]);

        if (!isset($response['similartags']['tag'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Tag::fromApi($data);
            },
            $response['similartags']['tag']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTopAlbums(string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('tag.getTopAlbums', [
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['albums']['album'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Album::fromApi($data);
            },
            $response['albums']['album']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTopArtists(string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('tag.getTopArtists', [
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
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

    /**
     * {@inheritdoc}
     */
    public function getTopTags(): array
    {
        $response = $this->client->unsignedCall('tag.getTopTags');

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

    /**
     * {@inheritdoc}
     */
    public function getTopTracks(string $tag, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('tag.getTopTracks', [
            'tag'   => $tag,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['tracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Song::fromApi($data);
            },
            $response['tracks']['track']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getWeeklyChartList(string $tag): array
    {
        $response = $this->client->unsignedCall('tag.getWeeklyChartList', [
            'tag' => $tag,
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
}
