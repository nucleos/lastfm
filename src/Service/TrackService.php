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

final class TrackService extends AbstractService
{
    /**
     * Tag an track using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     * @param array            $tags
     *
     * @throws ApiException
     */
    public function addTags(SessionInterface $session, $artist, $track, array $tags)
    {
        $count = count($tags);

        if ($count === 0) {
            return;
        } elseif ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->connection->signedCall('track.addTags', array(
            'artist' => $artist,
            'track'  => $track,
            'tags'   => implode(',', $tags),
        ), $session, 'POST');
    }

    /**
     * Check whether the supplied track has a correction to a canonical artist.
     *
     * @param string $artist
     * @param string $track
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getCorrection($artist, $track)
    {
        return $this->connection->unsignedCall('track.getCorrection', array(
            'artist' => $artist,
            'track'  => $track,
        ));
    }

    /**
     * Get the metadata for a track on Last.fm using the artist/track name.
     *
     * @param string $artist
     * @param string $track
     * @param null   $username
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getInfo($artist, $track, $username = null, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getInfo', array(
            'artist'      => $artist,
            'track'       => $track,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
        ));
    }

    /**
     * Get the metadata for a track on Last.fm using the musicbrainz id.
     *
     * @param string $mbid
     * @param null   $username
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getInfoByMBID($mbid, $username = null, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getInfo', array(
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
        ));
    }

    /**
     * Get the similar tracks for this track on Last.fm, based on listening data.
     *
     *
     * @param string $artist
     * @param string $track
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getSimilar($artist, $track, $limit = 10, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getSimilar', array(
            'artist'      => $artist,
            'track'       => $track,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the similar tracks for this track using the musicbrainz id on Last.fm, based on listening data.
     *
     *
     * @param string $mbid
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getSimilarByMBID($mbid, $limit = 10, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getSimilar', array(
            'mbid'        => $mbid,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the tags applied by an individual user to a track on Last.fm.
     *
     * @param string $artist
     * @param string $track
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws ApiException
     *
     * @return array
     */
    public function getTags($artist, $track, $username, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getTags', array(
            'artist'      => $artist,
            'track'       => $track,
            'user'        => $username,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the tags applied by an individual user to a track using the musicbrainz id on Last.fm.
     *
     * @param string $mbid
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws ApiException
     *
     * @return array
     */
    public function getTagsByMBID($mbid, $username, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getTags', array(
            'mbid'        => $mbid,
            'user'        => $username,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the top tags for this track on Last.fm, ordered by tag count.
     *
     * @param string $artist
     * @param string $track
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopTags($artist, $track, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getTopTags', array(
            'artist'      => $artist,
            'track'       => $track,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Get the top tags for this track using the musicbrainz id on Last.fm, ordered by tag count.
     *
     * @param string $bdid
     * @param bool   $autocorrect
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopTagsByMBID($bdid, $autocorrect = false)
    {
        return $this->connection->unsignedCall('track.getTopTags', array(
            'bdid'        => $bdid,
            'autocorrect' => (int) $autocorrect,
        ));
    }

    /**
     * Love a track for a user profile.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     *
     * @throws ApiException
     */
    public function love(SessionInterface $session, $artist, $track)
    {
        $this->connection->signedCall('track.love', array(
            'artist' => $artist,
            'track'  => $track,
        ), $session, 'POST');
    }

    /**
     * Remove a user's tag from a track.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     * @param string           $tag
     *
     * @throws ApiException
     */
    public function removeTag(SessionInterface $session, $artist, $track, $tag)
    {
        $this->connection->signedCall('track.removeTag', array(
            'artist' => $artist,
            'track'  => $track,
            'tag'    => $tag,
        ), $session, 'POST');
    }

    /**
     * Share a track twith one or more Last.fm users or other friends.
     *
     * @param SessionInterface $session
     * @param array            $tracks
     *
     * @throws ApiException
     */
    public function scrobble(SessionInterface $session, array $tracks)
    {
        $count = count($tracks);

        if ($count === 0) {
            return;
        } elseif ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 50 tracks is allowed');
        }

        $data = array();

        $i = 0;
        foreach ($tracks as $track) {
            // Required fields
            foreach (array('artist', 'track', 'timestamp') as $field) {
                if (!array_key_exists($field, $track)) {
                    throw new \InvalidArgumentException(sprintf('Field "%s" not set on entry %s', $field, $i));
                }
                $data[$field.'['.$i.']'] = $track[$field];
            }

            // Optional fields
            foreach (array('album', 'context', 'streamId', 'chosenByUser', 'trackNumber', 'mbid', 'albumArtist', 'duration') as $field) {
                if (array_key_exists($field, $track)) {
                    $data[$field.'['.$i.']'] = $track[$field];
                }
            }

            ++$i;
        }

        $this->connection->signedCall('album.scrobble', $data, $session, 'POST');
    }

    /**
     * Search for a track by track name. Returns track matches sorted by relevance.
     *
     * @param string $track
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function search($track, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('track.search', array(
            'track' => $track,
            'limit' => $limit,
            'page'  => $page,
        ));
    }

    /**
     * Unlove a track for a user profile..
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     *
     * @throws ApiException
     */
    public function unlove(SessionInterface $session, $artist, $track)
    {
        $this->connection->signedCall('track.love', array(
            'artist' => $artist,
            'track'  => $track,
        ), $session, 'POST');
    }

    /**
     * Share a track twith one or more Last.fm users or other friends.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     * @param string           $album
     * @param int              $trackNumber
     * @param string           $context
     * @param string           $mbid
     * @param string           $duration
     * @param string           $albumArtist
     *
     * @throws ApiException
     */
    public function updateNowPlaying(SessionInterface $session, $artist, $track, $album = null, $trackNumber = null, $context = null, $mbid = null, $duration = null, $albumArtist = null)
    {
        $this->connection->signedCall('track.updateNowPlaying', array(
            'artist'      => $artist,
            'track'       => $track,
            'album'       => $album,
            'trackNumber' => $trackNumber,
            'context'     => $context,
            'mbid'        => $mbid,
            'duration'    => $duration,
            'albumArtist' => $albumArtist,
        ), $session, 'POST');
    }
}
