<?php

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
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\AlbumInfo;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Session\SessionInterface;
use InvalidArgumentException;

interface AlbumServiceInterface
{
    /**
     * Tag an album using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string           $album
     * @param string[]         $tags
     *
     * @throws InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, string $album, array $tags): void;

    /**
     * Get the metadata for an album on Last.fm using the musicbrainz id.
     *
     * @param AlbumInfoBuilder $builder
     *
     * @return AlbumInfo
     */
    public function getInfo(AlbumInfoBuilder $builder): AlbumInfo;

    /**
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @param AlbumTagsBuilder $builder
     *
     * @return AlbumInfo[]
     */
    public function getTags(AlbumTagsBuilder $builder): array;

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @param AlbumTopTagsBuilder $builder
     *
     * @return Tag[]
     */
    public function getTopTags(AlbumTopTagsBuilder $builder): array;

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
    public function removeTag(SessionInterface $session, string $artist, string $album, string $tag): void;

    /**
     * Search for an album by name. Returns album matches sorted by relevance.
     *
     * @param string $album
     * @param int    $limit
     * @param int    $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Album[]
     */
    public function search(string $album, int $limit = 50, int $page = 1): array;
}
