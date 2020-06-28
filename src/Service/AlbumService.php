<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Service;

use InvalidArgumentException;
use Nucleos\LastFm\Builder\AlbumInfoBuilder;
use Nucleos\LastFm\Builder\AlbumTagsBuilder;
use Nucleos\LastFm\Builder\AlbumTopTagsBuilder;
use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Model\Album;
use Nucleos\LastFm\Model\AlbumInfo;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Session\SessionInterface;
use Nucleos\LastFm\Util\ApiHelper;

final class AlbumService implements AlbumServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    public function addTags(SessionInterface $session, string $artist, string $album, array $tags): void
    {
        $count = \count($tags);

        if (0 === $count) {
            throw new InvalidArgumentException('No tags given');
        }

        if ($count > 10) {
            throw new InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->client->signedCall('album.addTags', [
            'artist' => $artist,
            'album'  => $album,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    public function getInfo(AlbumInfoBuilder $builder): AlbumInfo
    {
        $response = $this->client->unsignedCall('album.getInfo', $builder->getQuery());

        return AlbumInfo::fromApi($response['album']);
    }

    public function getTags(AlbumTagsBuilder $builder): array
    {
        $response = $this->client->unsignedCall('album.getTags', $builder->getQuery());

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function (array $data): Tag {
                return Tag::fromApi($data);
            },
            $response['tags']['tag']
        );
    }

    public function getTopTags(AlbumTopTagsBuilder $builder): array
    {
        $response = $this->client->unsignedCall('album.getTopTags', $builder->getQuery());

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

    public function removeTag(SessionInterface $session, string $artist, string $album, string $tag): void
    {
        $this->client->signedCall('album.removeTag', [
            'artist' => $artist,
            'album'  => $album,
            'tag'    => $tag,
        ], $session, 'POST');
    }

    public function search(string $album, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('album.search', [
            'album' => $album,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['results']['albummatches']['album'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function (array $data): Album {
                return Album::fromApi($data);
            },
            $response['results']['albummatches']['album']
        );
    }
}
