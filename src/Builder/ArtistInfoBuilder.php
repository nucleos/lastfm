<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Builder;

final class ArtistInfoBuilder
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
     * @param string $artist
     *
     * @return ArtistInfoBuilder
     */
    public static function forArtist(string $artist): self
    {
        $builder = new static();

        $builder->query['artist'] = $artist;

        return $builder;
    }

    /**
     * @param string $mbid
     *
     * @return ArtistInfoBuilder
     */
    public static function forMbid(string $mbid): self
    {
        $builder = new static();

        $builder->query['mbid'] = $mbid;

        return $builder;
    }

    /**
     * @param bool $autocorrect
     *
     * @return ArtistInfoBuilder
     */
    public function autocorrect(bool $autocorrect): self
    {
        $this->query['autocorrect'] =  $autocorrect ? 1 : 0;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ArtistInfoBuilder
     */
    public function language(string $name): self
    {
        $this->query['lang'] = (int) $name;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ArtistInfoBuilder
     */
    public function forUsername(string $name): self
    {
        $this->query['username'] = (int) $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }
}
