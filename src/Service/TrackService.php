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
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\SongInfo;
use Core23\LastFm\Model\Tag;

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
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, string $track, array $tags): void
    {
        $count = \count($tags);

        if (0 === $count) {
            return;
        } elseif ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->signedCall('track.addTags', [
            'artist' => $artist,
            'track'  => $track,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    /**
     * Check whether the supplied track has a correction to a canonical artist.
     *
     * @param string $artist
     * @param string $track
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Song|null
     */
    public function getCorrection(string $artist, string $track): ?Song
    {
        $response = $this->unsignedCall('track.getCorrection', [
            'artist' => $artist,
            'track'  => $track,
        ]);

        if (!isset($response['corrections']['correction']['track'])) {
            return null;
        }

        return Song::fromApi($response['corrections']['correction']['track']);
    }

    /**
     * Get the metadata for a track on Last.fm using the artist/track name.
     *
     * @param string      $artist
     * @param string      $track
     * @param string|null $username
     * @param bool        $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo|null
     */
    public function getInfo(string $artist, string $track, ?string $username = null, $autocorrect = false): ?SongInfo
    {
        $response = $this->unsignedCall('track.getInfo', [
            'artist'      => $artist,
            'track'       => $track,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
        ]);

        if (!isset($response['track'])) {
            return null;
        }

        return SongInfo::fromApi($response['track']);
    }

    /**
     * Get the metadata for a track on Last.fm using the musicbrainz id.
     *
     * @param string      $mbid
     * @param string|null $username
     * @param bool        $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo|null
     */
    public function getInfoByMBID(string $mbid, ?string $username = null, $autocorrect = false): ?SongInfo
    {
        $response = $this->unsignedCall('track.getInfo', [
            'mbid'        => $mbid,
            'autocorrect' => (int) $autocorrect,
            'username'    => $username,
        ]);

        if (!isset($response['track'])) {
            return null;
        }

        return SongInfo::fromApi($response['track']);
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
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo[]
     */
    public function getSimilar(string $artist, string $track, int $limit = 10, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('track.getSimilar', [
            'artist'      => $artist,
            'track'       => $track,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['similartracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return SongInfo::fromApi($data);
        }, $response['similartracks']['track']);
    }

    /**
     * Get the similar tracks for this track using the musicbrainz id on Last.fm, based on listening data.
     *
     *
     * @param string $mbid
     * @param int    $limit
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo[]
     */
    public function getSimilarByMBID(string $mbid, int $limit = 10, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('track.getSimilar', [
            'mbid'        => $mbid,
            'limit'       => $limit,
            'autocorrect' => (int) $autocorrect,
        ]);

        if (!isset($response['similartracks']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return SongInfo::fromApi($data);
        }, $response['similartracks']['track']);
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
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getTags(string $artist, string $track, string $username, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('track.getTags', [
            'artist'      => $artist,
            'track'       => $track,
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
     * Get the tags applied by an individual user to a track using the musicbrainz id on Last.fm.
     *
     * @param string $mbid
     * @param string $username
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getTagsByMBID(string $mbid, string $username, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('track.getTags', [
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
     * Get the top tags for this track on Last.fm, ordered by tag count.
     *
     * @param string $artist
     * @param string $track
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getTopTags(string $artist, string $track, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('track.getTopTags', [
            'artist'      => $artist,
            'track'       => $track,
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
     * Get the top tags for this track using the musicbrainz id on Last.fm, ordered by tag count.
     *
     * @param string $bdid
     * @param bool   $autocorrect
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Tag[]
     */
    public function getTopTagsByMBID(string $bdid, bool $autocorrect = false): array
    {
        $response = $this->unsignedCall('track.getTopTags', [
            'bdid'        => $bdid,
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
     * Love a track for a user profile.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function love(SessionInterface $session, string $artist, string $track): void
    {
        $this->signedCall('track.love', [
            'artist' => $artist,
            'track'  => $track,
        ], $session, 'POST');
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
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, string $artist, string $track, string $tag): void
    {
        $this->signedCall('track.removeTag', [
            'artist' => $artist,
            'track'  => $track,
            'tag'    => $tag,
        ], $session, 'POST');
    }

    /**
     * Share a track twith one or more Last.fm users or other friends.
     *
     * @param SessionInterface $session
     * @param array            $tracks
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function scrobble(SessionInterface $session, array $tracks): void
    {
        $count = \count($tracks);

        if (0 === $count) {
            return;
        } elseif ($count > 10) {
            throw new \InvalidArgumentException('A maximum of 50 tracks is allowed');
        }

        $data = [];

        $i = 0;
        foreach ($tracks as $track) {
            // Required fields
            foreach (['artist', 'track', 'timestamp'] as $field) {
                if (!array_key_exists($field, $track)) {
                    throw new \InvalidArgumentException(sprintf('Field "%s" not set on entry %s', $field, $i));
                }
                $data[$field.'['.$i.']'] = $track[$field];
            }

            // Optional fields
            foreach (['album', 'context', 'streamId', 'chosenByUser', 'trackNumber', 'mbid', 'albumArtist', 'duration'] as $field) {
                if (array_key_exists($field, $track)) {
                    $data[$field.'['.$i.']'] = $track[$field];
                }
            }

            ++$i;
        }

        $this->signedCall('album.scrobble', $data, $session, 'POST');
    }

    /**
     * Search for a track by track name. Returns track matches sorted by relevance.
     *
     * @param string $track
     * @param int    $limit
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return SongInfo[]
     */
    public function search(string $track, int $limit = 50, int $page = 1): array
    {
        $response = $this->unsignedCall('track.search', [
            'track' => $track,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['results']['trackmatches']['track'])) {
            return [];
        }

        return array_map(function ($data) {
            return SongInfo::fromApi($data);
        }, $response['results']['trackmatches']['track']);
    }

    /**
     * Unlove a track for a user profile.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $track
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function unlove(SessionInterface $session, string $artist, string $track): void
    {
        $this->signedCall('track.love', [
            'artist' => $artist,
            'track'  => $track,
        ], $session, 'POST');
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
     * @throws NotFoundException
     */
    public function updateNowPlaying(SessionInterface $session, string $artist, string $track, string $album = null, $trackNumber = null, $context = null, $mbid = null, $duration = null, $albumArtist = null): void
    {
        $this->signedCall('track.updateNowPlaying', [
            'artist'      => $artist,
            'track'       => $track,
            'album'       => $album,
            'trackNumber' => $trackNumber,
            'context'     => $context,
            'mbid'        => $mbid,
            'duration'    => $duration,
            'albumArtist' => $albumArtist,
        ], $session, 'POST');
    }
}
