<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Builder\ArtistInfoBuilder;
use Core23\LastFm\Builder\ArtistTagsBuilder;
use Core23\LastFm\Builder\ArtistTopAlbumsBuilder;
use Core23\LastFm\Builder\ArtistTopTagsBuilder;
use Core23\LastFm\Builder\ArtistTopTracksBuilder;
use Core23\LastFm\Builder\SimilarArtistBuilder;
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\ArtistInfo;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Session\SessionInterface;
use InvalidArgumentException;

final class ArtistService extends AbstractService implements ArtistServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function addTags(SessionInterface $session, string $artist, array $tags): void
    {
        $count = \count($tags);

        if (0 === $count) {
            throw new InvalidArgumentException('No tags given');
        }
        if ($count > 10) {
            throw new InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        array_filter($tags, static function ($tag) {
            if (null === $tag || !\is_string($tag)) {
                throw new InvalidArgumentException(sprintf('Invalid tag given'));
            }
        });

        $this->signedCall('artist.addTags', [
            'artist' => $artist,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    /**
     * {@inheritdoc}
     */
    public function getCorrection(string $artist): ?Artist
    {
        $response = $this->unsignedCall('artist.getCorrection', [
            'artist' => $artist,
        ]);

        if (!isset($response['corrections']['correction']['artist'])) {
            return null;
        }

        return Artist::fromApi($response['corrections']['correction']['artist']);
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo(ArtistInfoBuilder $builder): ?ArtistInfo
    {
        $response = $this->unsignedCall('artist.getInfo', $builder->getQuery());

        if (!isset($response['artist'])) {
            return null;
        }

        return ArtistInfo::fromApi($response['artist']);
    }

    /**
     * {@inheritdoc}
     */
    public function getSimilar(SimilarArtistBuilder $builder): array
    {
        $response = $this->unsignedCall('artist.getSimilar', $builder->getQuery());

        if (!isset($response['similarartists']['artist'])) {
            return [];
        }

        return array_map(static function ($data) {
            return Artist::fromApi($data);
        }, $response['similarartists']['artist']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTags(ArtistTagsBuilder $builder): array
    {
        $response = $this->unsignedCall('artist.getTags', $builder->getQuery());

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return array_map(static function ($data) {
            return Tag::fromApi($data);
        }, $response['tags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopAlbums(ArtistTopAlbumsBuilder $builder): array
    {
        $response =  $this->unsignedCall('artist.getTopAlbums', $builder->getQuery());

        if (!isset($response['topalbums']['album'])) {
            return [];
        }

        return array_map(static function ($data) {
            return Album::fromApi($data);
        }, $response['topalbums']['album']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopTags(ArtistTopTagsBuilder $builder): array
    {
        $response = $this->unsignedCall('artist.getTopTags', $builder->getQuery());

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return array_map(static function ($data) {
            return Tag::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopTracks(ArtistTopTracksBuilder $builder): array
    {
        $response = $this->unsignedCall('artist.getTopTracks', $builder->getQuery());

        if (!isset($response['toptracks']['track'])) {
            return [];
        }

        return array_map(static function ($data) {
            return Song::fromApi($data);
        }, $response['toptracks']['track']);
    }

    /**
     * {@inheritdoc}
     */
    public function removeTag(SessionInterface $session, string $artist, string $tag): void
    {
        $this->signedCall('artist.removeTag', [
            'artist' => $artist,
            'tag'    => $tag,
        ], $session, 'POST');
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $artist, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('artist.search', [
            'artist' => $artist,
            'limit'  => $limit,
            'page'   => $page,
        ]);

        if (!isset($response['results']['artistmatches']['artist'])) {
            return [];
        }

        return array_map(static function ($data) {
            return Artist::fromApi($data);
        }, $response['results']['artistmatches']['artist']);
    }
}
