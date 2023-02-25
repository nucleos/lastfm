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
use Nucleos\LastFm\Builder\ArtistInfoBuilder;
use Nucleos\LastFm\Builder\ArtistTagsBuilder;
use Nucleos\LastFm\Builder\ArtistTopAlbumsBuilder;
use Nucleos\LastFm\Builder\ArtistTopTagsBuilder;
use Nucleos\LastFm\Builder\ArtistTopTracksBuilder;
use Nucleos\LastFm\Builder\SimilarArtistBuilder;
use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Model\Album;
use Nucleos\LastFm\Model\Artist;
use Nucleos\LastFm\Model\ArtistInfo;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Session\SessionInterface;
use Nucleos\LastFm\Util\ApiHelper;

final class ArtistService implements ArtistServiceInterface
{
    private ApiClientInterface $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    public function addTags(SessionInterface $session, string $artist, array $tags): void
    {
        $count = \count($tags);

        if (0 === $count) {
            throw new InvalidArgumentException('No tags given');
        }
        if ($count > 10) {
            throw new InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->client->signedCall('artist.addTags', [
            'artist' => $artist,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    public function getCorrection(string $artist): ?Artist
    {
        $response = $this->client->unsignedCall('artist.getCorrection', [
            'artist' => $artist,
        ]);

        if (!isset($response['corrections']['correction']['artist'])) {
            return null;
        }

        return Artist::fromApi($response['corrections']['correction']['artist']);
    }

    public function getInfo(ArtistInfoBuilder $builder): ?ArtistInfo
    {
        $response = $this->client->unsignedCall('artist.getInfo', $builder->getQuery());

        if (!isset($response['artist'])) {
            return null;
        }

        return ArtistInfo::fromApi($response['artist']);
    }

    public function getSimilar(SimilarArtistBuilder $builder): array
    {
        $response = $this->client->unsignedCall('artist.getSimilar', $builder->getQuery());

        if (!isset($response['similarartists']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function (array $data): Artist {
                return Artist::fromApi($data);
            },
            $response['similarartists']['artist']
        );
    }

    public function getTags(ArtistTagsBuilder $builder): array
    {
        $response = $this->client->unsignedCall('artist.getTags', $builder->getQuery());

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

    public function getTopAlbums(ArtistTopAlbumsBuilder $builder): array
    {
        $response =  $this->client->unsignedCall('artist.getTopAlbums', $builder->getQuery());

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

    public function getTopTags(ArtistTopTagsBuilder $builder): array
    {
        $response = $this->client->unsignedCall('artist.getTopTags', $builder->getQuery());

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

    public function getTopTracks(ArtistTopTracksBuilder $builder): array
    {
        $response = $this->client->unsignedCall('artist.getTopTracks', $builder->getQuery());

        if (!isset($response['toptracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function (array $data): Song {
                return Song::fromApi($data);
            },
            $response['toptracks']['track']
        );
    }

    public function removeTag(SessionInterface $session, string $artist, string $tag): void
    {
        $this->client->signedCall('artist.removeTag', [
            'artist' => $artist,
            'tag'    => $tag,
        ], $session, 'POST');
    }

    public function search(string $artist, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('artist.search', [
            'artist' => $artist,
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['results']['artistmatches']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function (array $data): Artist {
                return Artist::fromApi($data);
            },
            $response['results']['artistmatches']['artist']
        );
    }
}
