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
use Nucleos\LastFm\Builder\AlbumInfoBuilder;
use Nucleos\LastFm\Builder\AlbumTagsBuilder;
use Nucleos\LastFm\Builder\AlbumTopTagsBuilder;
use Nucleos\LastFm\Exception\ApiException;
use Nucleos\LastFm\Exception\NotFoundException;
use Nucleos\LastFm\Model\Album;
use Nucleos\LastFm\Model\AlbumInfo;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Session\SessionInterface;

interface AlbumServiceInterface
{
    /**
     * Tag an album using a list of user supplied tags.
     *
     * @param string[] $tags
     *
     * @throws InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, string $album, array $tags): void;

    /**
     * Get the metadata for an album on Last.fm using the musicbrainz id.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getInfo(AlbumInfoBuilder $builder): AlbumInfo;

    /**
     * Get the tags applied by an individual user to an album on Last.fm.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return AlbumInfo[]
     */
    public function getTags(AlbumTagsBuilder $builder): array;

    /**
     * Get the top tags applied to an album on Last.fm.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTags(AlbumTopTagsBuilder $builder): array;

    /**
     * Remove a user's tag from an album.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, string $artist, string $album, string $tag): void;

    /**
     * Search for an album by name. Returns album matches sorted by relevance.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Album[]
     */
    public function search(string $album, int $limit = 50, int $page = 1): array;
}
