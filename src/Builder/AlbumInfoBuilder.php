<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Builder;

final class AlbumInfoBuilder
{
    private array $query;

    private function __construct()
    {
        $this->query = [];
    }

    public static function forAlbum(string $artist, string $album): self
    {
        $builder = new static();

        $builder->query['artist'] = $artist;
        $builder->query['album']  = $album;

        return $builder;
    }

    public static function forMbid(string $mbid): self
    {
        $builder = new static();

        $builder->query['mbid'] = $mbid;

        return $builder;
    }

    public function forUsername(string $name): self
    {
        $this->query['username'] = $name;

        return $this;
    }

    public function language(string $name): self
    {
        $this->query['lang'] = $name;

        return $this;
    }

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
