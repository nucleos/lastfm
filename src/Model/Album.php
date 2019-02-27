<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class Album
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var Artist|null
     */
    private $artist;

    /**
     * @var string|null
     */
    private $mbid;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var Image[]
     */
    private $images;

    /**
     * @param string|null $name
     * @param Artist|null $artist
     * @param string|null $mbid
     * @param string|null $url
     * @param Image[]     $images
     */
    public function __construct(?string $name, ?Artist $artist, ?string $mbid, ?string $url, array $images)
    {
        $this->name   = $name;
        $this->artist = $artist;
        $this->mbid   = $mbid;
        $this->url    = $url;
        $this->images = $images;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Artist|null
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * @return string|null
     */
    public function getMbid(): ?string
    {
        return $this->mbid;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $data
     *
     * @return Album
     */
    public static function fromApi(array $data): self
    {
        $images = [];

        if (\array_key_exists('image', $data)) {
            foreach ((array) $data['image'] as $image) {
                $images[] = new Image($image['#text']);
            }
        }

        return new self(
            $data['name'],
            $data['artist'] ? Artist::fromApi($data['artist']) : null,
            $data['mbid'] ?? null,
            $data['url'] ?? null,
            $images
        );
    }
}
