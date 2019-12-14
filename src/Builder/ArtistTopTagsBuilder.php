<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Builder;

final class ArtistTopTagsBuilder
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
     * @return ArtistTopTagsBuilder
     */
    public static function forArtist(string $artist): self
    {
        $builder = new static();

        $builder->query['artist'] = $artist;

        return $builder;
    }

    /**
     * @return ArtistTopTagsBuilder
     */
    public static function forMbid(string $mbid): self
    {
        $builder = new static();

        $builder->query['mbid'] = $mbid;

        return $builder;
    }

    /**
     * @return ArtistTopTagsBuilder
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
