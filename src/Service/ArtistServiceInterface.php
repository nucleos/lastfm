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
use Nucleos\LastFm\Builder\ArtistInfoBuilder;
use Nucleos\LastFm\Builder\ArtistTagsBuilder;
use Nucleos\LastFm\Builder\ArtistTopAlbumsBuilder;
use Nucleos\LastFm\Builder\ArtistTopTagsBuilder;
use Nucleos\LastFm\Builder\ArtistTopTracksBuilder;
use Nucleos\LastFm\Builder\SimilarArtistBuilder;
use Nucleos\LastFm\Exception\ApiException;
use Nucleos\LastFm\Exception\NotFoundException;
use Nucleos\LastFm\Model\Album;
use Nucleos\LastFm\Model\Artist;
use Nucleos\LastFm\Model\ArtistInfo;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Session\SessionInterface;

interface ArtistServiceInterface
{
    /**
     * Tag an artist using a list of user supplied tags.
     *
     * @param string[] $tags
     *
     * @throws InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, array $tags): void;

    /**
     * Check whether the supplied artist has a correction to a canonical artist.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getCorrection(string $artist): ?Artist;

    /**
     * Get the metadata for an artist on Last.fm. Includes biography.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getInfo(ArtistInfoBuilder $builder): ?ArtistInfo;

    /**
     * Get all the artists similar to this artist.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist[]
     */
    public function getSimilar(SimilarArtistBuilder $builder): array;

    /**
     * Get the tags applied by an individual user to an artist on Last.fm.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTags(ArtistTagsBuilder $builder): array;

    /**
     * Get the top albums for an artist on Last.fm, ordered by popularity.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Album[]
     */
    public function getTopAlbums(ArtistTopAlbumsBuilder $builder): array;

    /**
     * Get the top tags for an artist on Last.fm, ordered by popularity.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Tag[]
     */
    public function getTopTags(ArtistTopTagsBuilder $builder): array;

    /**
     * Get the top tracks by an artist on Last.fm, ordered by popularity.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Song[]
     */
    public function getTopTracks(ArtistTopTracksBuilder $builder): array;

    /**
     * Remove a user's tag from an artist.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, string $artist, string $tag): void;

    /**
     * Search for an artist by name. Returns artist matches sorted by relevance.
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist[]
     */
    public function search(string $artist, int $limit = 50, int $page = 1): array;
}
