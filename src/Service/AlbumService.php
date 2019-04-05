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
use Core23\LastFm\Model\AlbumInfo;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Session\SessionInterface;
use InvalidArgumentException;

final class AlbumService extends AbstractService implements AlbumServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function addTags(SessionInterface $session, string $artist, string $album, array $tags): void
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

        $this->signedCall('album.addTags', [
            'artist' => $artist,
            'album'  => $album,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    /**
     * {@inheritdoc}
     */
    public function getInfoByMBID(string $mbid, bool $autocorrect = false, ?string $username = null, $lang = null): AlbumInfo
    {
        $response = $this->unsignedCall('album.getInfo', [
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
            'lang'        => $lang,
        ]);

        return AlbumInfo::fromApi($response['album']);
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo(string $artist, string $album, bool $autocorrect = false, ?string $username = null, ?string $lang = null): AlbumInfo
    {
        $response = $this->unsignedCall('album.getInfo', [
            'artist'      => $artist,
            'album'       => $album,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
            'lang'        => $lang,
        ]);

        return AlbumInfo::fromApi($response['album']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTags(string $artist, string $album, string $username, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('album.getTags', [
            'artist'      => $artist,
            'album'       => $album,
            'autocorrect' => (int) $autocorrect,
            'user'        => $username,
        ]);

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
    public function getTagsByMBID(string $mbid, string $username, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('album.getTags', [
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
            'user'        => $username,
        ]);

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
    public function getTopTags(string $artist, string $album, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('album.getTopTags', [
            'artist'      => $artist,
            'album'       => $album,
            'autocorrect' => (int) $autocorrect,
        ]);

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
    public function getTopTagsByMBID(string $mbid, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('album.getTopTags', [
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return array_map(static function ($data) {
            return AlbumInfo::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function removeTag(SessionInterface $session, string $artist, string $album, string $tag): void
    {
        $this->signedCall('album.removeTag', [
            'artist' => $artist,
            'album'  => $album,
            'tag'    => $tag,
        ], $session, 'POST');
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $album, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('album.search', [
            'album' => $album,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['results']['albummatches']['album'])) {
            return [];
        }

        return array_map(static function ($data) {
            return Album::fromApi($data);
        }, $response['results']['albummatches']['album']);
    }
}
