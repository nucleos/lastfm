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

    /**
     * @param string      $name
     * @param int|null    $duration
     * @param Artist|null $artist
     */
    public function __construct(string $name, ?int $duration, ?Artist $artist)
    {
        $this->name     = $name;
        $this->duration = $duration;
        $this->artist   = $artist;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @return Artist|null
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * @param array $data
     *
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
