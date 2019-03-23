<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\ArtistInfo;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Session\SessionInterface;

final class ArtistService extends AbstractService implements ArtistServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function addTags(SessionInterface $session, string $artist, array $tags): void
    {
        $count = \count($tags);

        if (0 === $count) {
            return;
        }
        if ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 10 tags is allowed');
        }

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
    public function getInfo(string $artist): ?ArtistInfo
    {
        $response = $this->unsignedCall('artist.getInfo', [
            'artist' => $artist,
        ]);

        if (!isset($response['artist'])) {
            return null;
        }

        return ArtistInfo::fromApi($response['artist']);
    }

    /**
     * {@inheritdoc}
     */
    public function getSimilar(string $artist, int $limit = 50, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getSimilar', [
            'artist'      => $artist,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['similarartists']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['similarartists']['artist']);
    }

    /**
     * {@inheritdoc}
     */
    public function getSimilarByMBID(string $mbid, int $limit = 50, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getSimilar', [
            'mbid'        => $mbid,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['similarartists']['artist'])) {
            return [];
        }

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['similarartists']['artist']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTags(string $artist, string $username, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getTags', [
            'artist'      => $artist,
            'user'        => $username,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['tags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTagsByMBID(string $mbid, string $username, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getTags', [
            'mbid'        => $mbid,
            'user'        => $username,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['tags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopAlbums(string $artist, int $page = 1, int $limit = 10, bool $autocorrect = false): array
    {
        $response =  $this->unsignedCall('artist.getTopAlbums', [
            'artist'      => $artist,
            'page'        => $page,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['topalbums']['album'])) {
            return [];
        }

        return array_map(function ($data) {
            return Album::fromApi($data);
        }, $response['topalbums']['album']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopAlbumsByMBID(string $mbid, int $page = 1, int $limit = 10, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getTopAlbums', [
            'mbid'        => $mbid,
            'page'        => $page,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['topalbums']['album'])) {
            return [];
        }

        return array_map(function ($data) {
            return Album::fromApi($data);
        }, $response['topalbums']['album']);
    }

    public function getTopTags(string $artist, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getTopTags', [
            'artist'      => $artist,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopTagsByMBID(string $mbid, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getTopTags', [
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopTracks(string $artist, int $page = 1, int $limit = 10, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getTopTracks', [
            'artist'      => $artist,
            'page'        => $page,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['toptracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return Song::fromApi($data);
        }, $response['toptracks']['track']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopTracksByMBID(string $mbid, int $page = 1, int $limit = 10, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('artist.getTopTracks', [
            'mbid'        => $mbid,
            'page'        => $page,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['toptracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
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

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['results']['artistmatches']['artist']);
    }
}
