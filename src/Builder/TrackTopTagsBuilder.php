<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Builder;

final class TrackTopTagsBuilder
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
     * @param string $track
     *
     * @return TrackTopTagsBuilder
     */
    public static function forTrack(string $artist, string $track): self
    {
        $builder = new static();

        $builder->query['artist'] = $artist;
        $builder->query['track']  = $track;

        return $builder;
    }

    /**
     * @param string $mbid
     *
     * @return TrackTopTagsBuilder
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
     * @return TrackTopTagsBuilder
     */
    public function autocorrect(bool $autocorrect): self
    {
        $this->query['autocorrect'] =  $autocorrect ? 1 : 0;

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
