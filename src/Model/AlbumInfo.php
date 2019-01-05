<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class AlbumInfo
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
     * @var int
     */
    private $listeners;

    /**
     * @var int
     */
    private $playcount;

    /**
     * @var Song[]
     */
    private $tracks;

    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @var string|null
     */
    private $wikiSummary;

    /**
     * @param string|null $name
     * @param Artist|null $artist
     * @param string|null $mbid
     * @param string|null $url
     * @param Image[]     $images
     * @param int         $listeners
     * @param int         $playcount
     * @param Song[]      $tracks
     * @param Tag[]       $tags
     * @param string|null $wikiSummary
     */
    public function __construct(
        ?string $name,
        ?Artist $artist,
        ?string $mbid,
        ?string $url,
        array $images,
        int $listeners,
        int $playcount,
        array $tracks,
        array $tags,
        ?string $wikiSummary
    ) {
        $this->name         = $name;
        $this->artist       = $artist;
        $this->mbid         = $mbid;
        $this->url          = $url;
        $this->images       = $images;
        $this->listeners    = $listeners;
        $this->playcount    = $playcount;
        $this->tracks       = $tracks;
        $this->tags         = $tags;
        $this->wikiSummary  = $wikiSummary;
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
    public function getImage(): array
    {
        return $this->images;
    }

    /**
     * @return int
     */
    public function getListeners(): int
    {
        return $this->listeners;
    }

    /**
     * @return int
     */
    public function getPlaycount(): int
    {
        return $this->playcount;
    }

    /**
     * @return Song[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return string|null
     */
    public function getWikiSummary(): ?string
    {
        return $this->wikiSummary;
    }

    /**
     * @param array $data
     *
     * @return AlbumInfo
     */
    public static function fromApi(array $data): self
    {
        $images = [];
        $tracks = [];
        $tags   = [];

        if (array_key_exists('image', $data)) {
            foreach ((array) $data['image'] as $image) {
                $images[] = new Image($image['#text']);
            }
        }

        if (array_key_exists('tracks', $data) && array_key_exists('track', $data['tracks'])) {
            foreach ((array) $data['tracks']['track'] as $track) {
                $tracks[] = Song::fromApi($track);
            }
        }

        if (array_key_exists('tags', $data) && array_key_exists('tag', $data['tags'])) {
            foreach ((array) $data['tags']['tag'] as $tag) {
                $tags[] = Tag::fromApi($tag);
            }
        }

        return new self(
            $data['name'],
            new Artist($data['artist'], null, [], null),
            $data['mbid'] ?? null,
            $data['url'] ?? null,
            $images,
            $data['listeners'] ?? 0,
            $data['playcount'] ?? 0,
            $tracks,
            $tags,
            $data['wiki']['summary'] ?? null
        );
    }
}
