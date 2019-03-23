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
use Core23\LastFm\Model\NowPlaying;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\SongInfo;
use Core23\LastFm\Model\Tag;
use InvalidArgumentException;

final class TrackService extends AbstractService implements TrackServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function addTags(SessionInterface $session, string $artist, string $track, array $tags): void
    {
        $count = \count($tags);

        if (0 === $count) {
            return;
        }
        if ($count > 10) {
            throw new InvalidArgumentException('A maximum of 10 tags is allowed');
        }

        $this->signedCall('track.addTags', [
            'artist' => $artist,
            'track'  => $track,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function love(SessionInterface $session, string $artist, string $track): void
    {
        $this->signedCall('track.love', [
            'artist' => $artist,
            'track'  => $track,
        ], $session, 'POST');
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function scrobble(SessionInterface $session, array $tracks): void
    {
        $count = \count($tracks);

        if (0 === $count) {
            return;
        }
        if ($count > 10) {
            throw new InvalidArgumentException('A maximum of 50 tracks is allowed');
        }

        $data = self::buildTrackList($tracks);

        $this->signedCall('album.scrobble', $data, $session, 'POST');
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function unlove(SessionInterface $session, string $artist, string $track): void
    {
        $this->signedCall('track.love', [
            'artist' => $artist,
            'track'  => $track,
        ], $session, 'POST');
    }

    /**
     * {@inheritdoc}
     */
    public function updateNowPlaying(SessionInterface $session, NowPlaying $nowPlaying): void
    {
        $this->signedCall('track.updateNowPlaying', $nowPlaying->toArray(), $session, 'POST');
    }

    /**
     * @param array $tracks
     *
     * @return array
     */
    private static function buildTrackList(array $tracks): array
    {
        $data = [];

        $i = 0;
        foreach ($tracks as $track) {
            // Required fields
            foreach (['artist', 'track', 'timestamp'] as $field) {
                if (!\array_key_exists($field, $track)) {
                    throw new InvalidArgumentException(sprintf('Field "%s" not set on entry %s', $field, $i));
                }
                $data[$field.'['.$i.']'] = $track[$field];
            }

            // Optional fields
            foreach (['album', 'context', 'streamId', 'chosenByUser', 'trackNumber', 'mbid', 'albumArtist', 'duration'] as $field) {
                if (\array_key_exists($field, $track)) {
                    $data[$field.'['.$i.']'] = $track[$field];
                }
            }

            ++$i;
        }

        return $data;
    }
}
