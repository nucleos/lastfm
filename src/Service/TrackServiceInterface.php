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
use Nucleos\LastFm\Exception\ApiException;
use Nucleos\LastFm\Exception\NotFoundException;
use Nucleos\LastFm\Model\NowPlaying;
use Nucleos\LastFm\Model\Song;
use Nucleos\LastFm\Model\SongInfo;
use Nucleos\LastFm\Model\Tag;
use Nucleos\LastFm\Session\SessionInterface;

interface TrackServiceInterface
{
    /**
     * Tag an track using a list of user supplied tags.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function addTags(SessionInterface $session, string $artist, string $track, array $tags): void;

    /**
     * Check whether the supplied track has a correction to a canonical artist.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getCorrection(string $artist, string $track): ?Song;

    /**
     * Get the metadata for a track on Last.fm using the artist/track name.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getInfo(TrackInfoBuilder $builder): ?SongInfo;

    /**
     * Get the similar tracks for this track on Last.fm, based on listening data.
     *
     * @return SongInfo[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getSimilar(SimilarTrackBuilder $builder): array;

    /**
     * Get the tags applied by an individual user to a track on Last.fm.
     *
     * @return Tag[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTags(TrackTagsBuilder $builder): array;

    /**
     * Get the top tags for this track on Last.fm, ordered by tag count.
     *
     * @return Tag[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function getTopTags(TrackTopTagsBuilder $builder): array;

    /**
     * Love a track for a user profile.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function love(SessionInterface $session, string $artist, string $track): void;

    /**
     * Remove a user's tag from a track.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function removeTag(SessionInterface $session, string $artist, string $track, string $tag): void;

    /**
     * Share a track twith one or more Last.fm users or other friends.
     *
     * @throws InvalidArgumentException
     * @throws NotFoundException
     * @throws ApiException
     */
    public function scrobble(SessionInterface $session, ScrobbeBuilder $builder): void;

    /**
     * Search for a track by track name. Returns track matches sorted by relevance.
     *
     * @return SongInfo[]
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function search(string $track, int $limit = 50, int $page = 1): array;

    /**
     * Unlove a track for a user profile.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function unlove(SessionInterface $session, string $artist, string $track): void;

    /**
     * Share a track twith one or more Last.fm users or other friends.
     *
     * @throws NotFoundException
     * @throws ApiException
     */
    public function updateNowPlaying(SessionInterface $session, NowPlaying $nowPlaying): void;
}
