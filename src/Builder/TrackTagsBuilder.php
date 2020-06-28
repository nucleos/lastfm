<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Builder;

final class TrackTagsBuilder
{
    /**
     * @var array
     */
    private $query;

    private function __construct()
    {
        $this->query = [];
    }

    /**
     * @return TrackTagsBuilder
     */
    public static function forTrack(string $artist, string $track): self
    {
        $builder = new static();

        $builder->query['artist'] = $artist;
        $builder->query['track']  = $track;

        return $builder;
    }

    /**
     * @return TrackTagsBuilder
     */
    public static function forMbid(string $mbid): self
    {
        $builder = new static();

        $builder->query['mbid'] = $mbid;

        return $builder;
    }

    /**
     * @return TrackTagsBuilder
     */
    public function forUsername(string $name): self
    {
        $this->query['user'] = $name;

        return $this;
    }

    /**
     * @return TrackTagsBuilder
     */
    public function autocorrect(bool $autocorrect): self
    {
        $this->query['autocorrect'] =  $autocorrect ? 1 : 0;

        return $this;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
