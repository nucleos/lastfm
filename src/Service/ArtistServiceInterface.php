<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Builder\ArtistInfoBuilder;
use Core23\LastFm\Builder\ArtistTagsBuilder;
use Core23\LastFm\Builder\ArtistTopAlbumsBuilder;
use Core23\LastFm\Builder\ArtistTopTagsBuilder;
use Core23\LastFm\Builder\ArtistTopTracksBuilder;
use Core23\LastFm\Builder\SimilarArtistBuilder;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;
use Core23\LastFm\Model\Album;
use Core23\LastFm\Model\Artist;
use Core23\LastFm\Model\ArtistInfo;
use Core23\LastFm\Model\Song;
use Core23\LastFm\Model\Tag;
use Core23\LastFm\Session\SessionInterface;
use InvalidArgumentException;

interface ArtistServiceInterface
{
    /**
     * Tag an artist using a list of user supplied tags.
     *
     * @param SessionInterface $session
     * @param string           $artist
     * @param string[]         $tags
     *
     * @throws InvalidArgumentException
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, array $tags): void;

    /**
     * Check whether the supplied artist has a correction to a canonical artist.
     *
     * @param string $artist
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist|null
     */
    public function getCorrection(string $artist): ?Artist;

    /**
     * Get the metadata for an artist on Last.fm. Includes biography.
     *
     * @param ArtistInfoBuilder $builder
     *
     * @return ArtistInfo|null
     */
    public function getInfo(ArtistInfoBuilder $builder): ?ArtistInfo;

    /**
     * Get all the artists similar to this artist.
     *
     * @param SimilarArtistBuilder $builder
     *
     * @return Artist[]
     */
    public function getSimilar(SimilarArtistBuilder $builder): array;

    /**
     * Get the tags applied by an individual user to an artist on Last.fm.
     *
     * @param ArtistTagsBuilder $builder
     *
     * @return Tag[]
     */
    public function getTags(ArtistTagsBuilder $builder): array;

    /**
     * Get the top albums for an artist on Last.fm, ordered by popularity.
     *
     * @param ArtistTopAlbumsBuilder $builder
     *
     * @return Album[]
     */
    public function getTopAlbums(ArtistTopAlbumsBuilder $builder): array;

    /**
     * Get the top tags for an artist on Last.fm, ordered by popularity.
     *
     * @param ArtistTopTagsBuilder $builder
     *
     * @return Tag[]
     */
    public function getTopTags(ArtistTopTagsBuilder $builder): array;

    /**
     * Get the top tracks by an artist on Last.fm, ordered by popularity.
     *
     * @param ArtistTopTracksBuilder $builder
     *
     * @return Song[]
     */
    public function getTopTracks(ArtistTopTracksBuilder $builder): array;

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
    public function removeTag(SessionInterface $session, string $artist, string $tag): void;

    /**
     * Search for an artist by name. Returns artist matches sorted by relevance.
     *
     * @param string $artist
     * @param int    $limit
     * @param int    $page
     *
     * @throws NotFoundException
     * @throws ApiException
     *
     * @return Artist[]
     */
    public function search(string $artist, int $limit = 50, int $page = 1): array;
}
