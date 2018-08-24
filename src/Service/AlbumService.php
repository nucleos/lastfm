<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Connection\SessionInterface;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\AlbumInfo;
use Core23\LastFm\Model\Tag;

final class AlbumService extends AbstractService
{
    /**
     * Tag an album using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $album
     * @param string[]         $tags
     *
     * @throws \InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, string $album, array $tags): void
    {
        $count = \count($tags);

        if (0 === $count) {
            return;
        } elseif ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->signedCall('album.addTags', [
            'artist' => $artist,
            'album'  => $album,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    /**
     * Get the metadata for an album on Last.fm using the musicbrainz id.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     * @param string $username
     * @param string $lang
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return AlbumInfo
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
     * Get the metadata for an album on Last.fm using the album name.
     *
     * @param string $artist
     * @param string $album
     * @param bool   $autocorrect
     * @param string $username
     * @param string $lang
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return AlbumInfo
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
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @param string $artist
     * @param string $album
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return AlbumInfo[]
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

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['tags']['tag']);
    }

    /**
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @param string $mbid
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return AlbumInfo[]
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

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['tags']['tag']);
    }

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @param string $artist
     * @param string $album
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
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

        return array_map(function ($data) {
            return Tag::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return AlbumInfo[]
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

        return array_map(function ($data) {
            return AlbumInfo::fromApi($data);
        }, $response['toptags']['tag']);
    }

    /**
     * Remove a user's tag from an album.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $album
     * @param string           $tag
     *
     * @throws ApiException
     * @throws NotFoundException
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
     * Search for an album by name. Returns album matches sorted by relevance.
     *
     * @param string $album
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Album[]
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

        return array_map(function ($data) {
            return Album::fromApi($data);
        }, $response['results']['albummatches']['album']);
    }
}
