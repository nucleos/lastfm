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
use Nucleos\LastFm\Builder\ScrobbeBuilder;
use Nucleos\LastFm\Builder\SimilarTrackBuilder;
use Nucleos\LastFm\Builder\TrackInfoBuilder;
use Nucleos\LastFm\Builder\TrackTagsBuilder;
use Nucleos\LastFm\Builder\TrackTopTagsBuilder;
use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Model\NowPlaying;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\SongInfo;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Session\SessionInterface;
use Nucleos\LastFm\Util\ApiHelper;

final class TrackService implements TrackServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    public function addTags(SessionInterface $session, string $artist, string $track, array $tags): void
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

        $this->client->signedCall('track.addTags', [
            'artist' => $artist,
            'track'  => $track,
            'tags'   => implode(',', $tags),
        ], $session, 'POST');
    }

    public function getCorrection(string $artist, string $track): ?Song
    {
        $response = $this->client->unsignedCall('track.getCorrection', [
            'artist' => $artist,
            'track'  => $track,
        ]);

        if (!isset($response['corrections']['correction']['track'])) {
            return null;
        }

        return Song::fromApi($response['corrections']['correction']['track']);
    }

    public function getInfo(TrackInfoBuilder $builder): ?SongInfo
    {
        $response = $this->client->unsignedCall('track.getInfo', $builder->getQuery());

        if (!isset($response['track'])) {
            return null;
        }

        return SongInfo::fromApi($response['track']);
    }

    public function getSimilar(SimilarTrackBuilder $builder): array
    {
        $response = $this->client->unsignedCall('track.getSimilar', $builder->getQuery());

        if (!isset($response['similartracks']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return SongInfo::fromApi($data);
            },
            $response['similartracks']['track']
        );
    }

    public function getTags(TrackTagsBuilder $builder): array
    {
        $response = $this->client->unsignedCall('track.getTags', $builder->getQuery());

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Tag::fromApi($data);
            },
            $response['tags']['tag']
        );
    }

    public function getTopTags(TrackTopTagsBuilder $builder): array
    {
        $response = $this->client->unsignedCall('track.getTopTags', $builder->getQuery());

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return Tag::fromApi($data);
            },
            $response['toptags']['tag']
        );
    }

    public function love(SessionInterface $session, string $artist, string $track): void
    {
        $this->client->signedCall('track.love', [
            'artist' => $artist,
            'track'  => $track,
        ], $session, 'POST');
    }

    public function removeTag(SessionInterface $session, string $artist, string $track, string $tag): void
    {
        $this->client->signedCall('track.removeTag', [
            'artist' => $artist,
            'track'  => $track,
            'tag'    => $tag,
        ], $session, 'POST');
    }

    public function scrobble(SessionInterface $session, ScrobbeBuilder $builder): void
    {
        $count = $builder->count();

        if (0 === $count) {
            return;
        }
        if ($count > 10) {
            throw new InvalidArgumentException('A maximum of 50 tracks is allowed');
        }

        $this->client->signedCall('album.scrobble', $builder->getQuery(), $session, 'POST');
    }

    public function search(string $track, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('track.search', [
            'track' => $track,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['results']['trackmatches']['track'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function ($data) {
                return SongInfo::fromApi($data);
            },
            $response['results']['trackmatches']['track']
        );
    }

    public function unlove(SessionInterface $session, string $artist, string $track): void
    {
        $this->client->signedCall('track.love', [
            'artist' => $artist,
            'track'  => $track,
        ], $session, 'POST');
    }

    public function updateNowPlaying(SessionInterface $session, NowPlaying $nowPlaying): void
    {
        $this->client->signedCall('track.updateNowPlaying', $nowPlaying->toArray(), $session, 'POST');
    }
}
