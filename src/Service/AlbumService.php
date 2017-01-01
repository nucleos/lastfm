<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Connection\SessionInterface;
use Core23\LastFm\Exception\ApiException;

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
     */
    public function addTags(SessionInterface $session, $artist, $album, array $tags)
    {
        $count = count($tags);

        if ($count === 0) {
            return;
        } elseif ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->connection->signedCall('album.addTags', array(
            'artist' => $artist,
            'album'  => $album,
            'tags'   => implode(',', $tags),
        ), $session, 'POST');
    }

    /**
     * Get the metadata for an album on Last.fm using the musicbrainz id.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     * @param string $username
     * @param string $lang
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getInfoByMBID($mbid, $autocorrect = false, $username = null, $lang = null)
    {
        return $this->connection->unsignedCall('album.getInfo', array(
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
            'lang'        => $lang,
        ));
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
     * @return array
     *
     * @throws ApiException
     */
    public function getInfo($artist, $album, $autocorrect = false, $username = null, $lang = null)
    {
        return $this->connection->unsignedCall('album.getInfo', array(
            'artist'      => $artist,
            'album'       => $album,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
            'lang'        => $lang,
        ));
    }

    /**
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @param string $artist
     * @param string $album
     * @param string $username
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTags($artist, $album, $username, $autocorrect = false)
    {
        return $this->connection->unsignedCall('album.getTags', array(
            'artist'      => $artist,
            'album'       => $album,
            'autocorrect' => (int) $autocorrect,
            'user'        => $username,
        ));
    }

    /**
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @param string $mbid
     * @param string $username
     * @param bool   $autocorrect
     *
     * @return array
     */
    public function getTagsByMBID($mbid, $username, $autocorrect = false)
    {
        return $this->connection->unsignedCall('album.getTags', array(
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
            'user'        => $username,
        ));
    }

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @param string $artist
     * @param string $album
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopTags($artist, $album, $autocorrect = false)
    {
        return $this->connection->unsignedCall('album.getTopTags', array(
            'artist'      => $artist,
            'album'       => $album,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopTagsByMBID($mbid, $autocorrect = false)
    {
        return $this->connection->unsignedCall('album.getTopTags', array(
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
        ));
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
     */
    public function removeTag(SessionInterface $session, $artist, $album, $tag)
    {
        $this->connection->signedCall('album.removeTag', array(
            'artist' => $artist,
            'album'  => $album,
            'tag'    => $tag,
        ), $session, 'POST');
    }

    /**
     * Search for an album by name. Returns album matches sorted by relevance.
     *
     * @param string $album
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function search($album, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('album.search', array(
            'album' => $album,
            'limit' => $limit,
            'page'  => $page,
        ));
    }
}
