<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Builder;

final class TrackInfoBuilder
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
     * @return TrackInfoBuilder
     */
    public static function forArtist(string $name): self
    {
        $builder = new static();

        $builder->query['artist'] = $name;

        return $builder;
    }

    /**
     * @return TrackInfoBuilder
     */
    public static function forMbid(string $mbid): self
    {
        $builder = new static();

        $builder->query['mbid'] = $mbid;

        return $builder;
    }

    /**
     * @return TrackInfoBuilder
     */
    public function forUsername(string $name): self
    {
        $this->query['username'] = $name;

        return $this;
    }

    /**
     * @return TrackInfoBuilder
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
