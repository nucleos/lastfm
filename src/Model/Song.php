<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class Song
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int|null
     */
    private $duration;

    /**
     * @var Artist|null
     */
    private $artist;

    public function __construct(string $name, ?int $duration, ?Artist $artist)
    {
        $this->name     = $name;
        $this->duration = $duration;
        $this->artist   = $artist;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * @return Song
     */
    public static function fromApi(array $data): self
    {
        $artist = isset($data['artist']) ? Artist::fromApi($data['artist']) : null;

        return new self(
            $data['name'],
            isset($data['duration']) ? (int) $data['duration'] : null,
            $artist
        );
    }
}
