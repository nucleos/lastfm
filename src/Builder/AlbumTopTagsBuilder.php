<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Builder;

final class AlbumTopTagsBuilder
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
     * @param string $album
     *
     * @return AlbumTopTagsBuilder
     */
    public static function forAlbum(string $artist, string $album): self
    {
        $builder = new static();

        $builder->query['artist'] = $artist;
        $builder->query['album']  = $album;

        return $builder;
    }

    /**
     * @param string $mbid
     *
     * @return AlbumTopTagsBuilder
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
     * @return AlbumTopTagsBuilder
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
