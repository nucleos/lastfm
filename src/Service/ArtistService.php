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
use Core23\LastFm\Exception\NotFoundException;

final class ArtistService extends AbstractService
{
    /**
     * Tag an artist using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string[]         $tags
     *
     * @throws \InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, $artist, array $tags)
    {
        $count = count($tags);

        if ($count === 0) {
            return;
        } elseif ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->signedCall('artist.addTags', array(
            'artist' => $artist,
            'tags' => implode(',', $tags),
        ), $session, 'POST');
    }

    /**
     * Check whether the supplied artist has a correction to a canonical artist.
     *
     * @param string $artist
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getCorrection($artist)
    {
        return $this->unsignedCall('artist.getCorrection', array(
            'artist' => $artist,
        ));
    }

    /**
     * Get the metadata for an artist on Last.fm. Includes biography.
     *
     * @param string $artist
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getInfo($artist)
    {
        return $this->unsignedCall('artist.getInfo', array(
            'artist' => $artist,
        ));
    }

    /**
     * Get all the artists similar to this artist.
     *
     * @param string $artist
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getSimilar($artist, $limit = 50, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getSimilar', array(
            'artist' => $artist,
            'limit' => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get all the artists similar to this artist using musicbrainz id.
     *
     * @param string $mbid
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getSimilarByMBID($mbid, $limit = 50, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getSimilar', array(
            'mbid' => $mbid,
            'limit' => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the tags applied by an individual user to an artist on Last.fm.
     *
     *
     * @param string $artist
     * @param string $username
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTags($artist, $username, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTags', array(
            'artist' => $artist,
            'user' => $username,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the tags applied by an individual user to an artist using musicbrainz id on Last.fm.
     *
     * @param string $mbid
     * @param string $username
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTagsByMBID($mbid, $username, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTags', array(
            'mbid' => $mbid,
            'user' => $username,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the top albums for an artist on Last.fm, ordered by popularity.
     *
     * @param string $artist
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopAlbums($artist, $page = 1, $limit = 10, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTopAlbums', array(
            'artist' => $artist,
            'page' => $page,
            'limit' => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the top albums for an artist using musicbrainz id on Last.fm, ordered by popularity.
     *
     * @param string $mbid
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopAlbumsByMBID($mbid, $page = 1, $limit = 10, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTopAlbums', array(
            'mbid' => $mbid,
            'page' => $page,
            'limit' => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the top tags for an artist on Last.fm, ordered by popularity.
     *
     * @param string $artist
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTags($artist, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTopTags', array(
                'artist' => $artist,
                'autocorrect' => (int) $autocorrect,
            ));
    }

    /**
     * Get the top tags for an artist on Last.fm using musicbrainz id, ordered by popularity.
     *
     * @param string $mbid
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTagsByMBID($mbid, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTopTags', array(
                'mbid' => $mbid,
                'autocorrect' => (int) $autocorrect,
            ));
    }

    /**
     * Get the top tracks by an artist on Last.fm, ordered by popularity.
     *
     * @param string $artist
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTracks($artist, $page = 1, $limit = 10, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTopTracks', array(
            'artist' => $artist,
            'page' => $page,
            'limit' => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the top tracks by an artist on Last.fm using musicbrainz id, ordered by popularity.
     *
     * @param string $mbid
     * @param int    $page
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getTopTracksByMBID($mbid, $page = 1, $limit = 10, $autocorrect = false)
    {
        return $this->unsignedCall('artist.getTopTracks', array(
            'mbid' => $mbid,
            'page' => $page,
            'limit' => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Remove a user's tag from an artist.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $tag
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, $artist, $tag)
    {
        $this->signedCall('artist.removeTag', array(
            'artist' => $artist,
            'tag' => $tag,
        ), $session, 'POST');
    }

    /**
     * Search for an artist by name. Returns artist matches sorted by relevance.
     *
     * @param string $artist
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search($artist, $limit = 50, $page = 1)
    {
        return $this->unsignedCall('artist.search', array(
            'artist' => $artist,
            'limit' => $limit,
            'page' => $page,
        ));
    }
}
