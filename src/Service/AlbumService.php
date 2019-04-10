<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Builder\AlbumInfoBuilder;
use Core23\LastFm\Builder\AlbumTagsBuilder;
use Core23\LastFm\Builder\AlbumTopTagsBuilder;
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
    public function getInfo(AlbumInfoBuilder $builder): AlbumInfo
    {
        $response = $this->unsignedCall('album.getInfo', $builder->getQuery());

        return AlbumInfo::fromApi($response['album']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTags(AlbumTagsBuilder $builder): array
    {
        $response = $this->unsignedCall('album.getTags', $builder->getQuery());

        if (!isset($response['tags']['tag'])) {
            return [];
        }

        return $this->mapToList(static function ($data) {
            return Tag::fromApi($data);
        }, $response['tags']['tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTopTags(AlbumTopTagsBuilder $builder): array
    {
        $response = $this->unsignedCall('album.getTopTags', $builder->getQuery());

        if (!isset($response['toptags']['tag'])) {
            return [];
        }

        return $this->mapToList(static function ($data) {
            return Tag::fromApi($data);
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

        return $this->mapToList(static function ($data) {
            return Album::fromApi($data);
        }, $response['results']['albummatches']['album']);
    }
}
