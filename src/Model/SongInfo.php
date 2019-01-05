<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class SongInfo
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $mbid;

    /**
     * @var int|null
     */
    private $duration;

    /**
     * @var Artist|null
     */
    private $artist;

    /**
     * @var int
     */
    private $listeners;

    /**
     * @var int
     */
    private $playcount;

    /**
     * @var Tag[]
     */
    private $topTags;

    /**
     * @param string      $name
     * @param string|null $mbid
     * @param int|null    $duration
     * @param Artist|null $artist
     * @param int         $listeners
     * @param int         $playcount
     * @param Tag[]       $topTags
     */
    public function __construct(
        string $name,
        ?string $mbid,
        ?int $duration,
        ?Artist $artist,
        int $listeners,
        int $playcount,
        array $topTags
    ) {
        $this->name      = $name;
        $this->mbid      = $mbid;
        $this->duration  = $duration;
        $this->artist    = $artist;
        $this->listeners = $listeners;
        $this->playcount = $playcount;
        $this->topTags   = $topTags;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getMbid(): ?string
    {
        return $this->mbid;
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
     * @return Tag[]
     */
    public function getTopTags(): array
    {
        return $this->topTags;
    }

    /**
     * @param array $data
     *
     * @return SongInfo
     */
    public static function fromApi(array $data): self
    {
        $tags   = [];

        if (isset($data['toptags']['tag'])) {
            foreach ((array) $data['toptags']['tag'] as $tag) {
                $tags[] = Tag::fromApi($tag);
            }
        }

        $artist = null;

        if (isset($data['artist'])) {
            if (\is_array($data['artist'])) {
                $artist = Artist::fromApi($data['artist']);
            } else {
                $artist = new Artist($data['artist'], null, [], null);
            }
        }

        return new self(
            $data['name'],
            $data['mbid'] ?? null,
            isset($data['duration']) ? (int) $data['duration'] : null,
            $artist,
            isset($data['listeners']) ? (int) $data['listeners'] : 0,
            isset($data['playcount']) ? (int) $data['playcount'] : 0,
            $tags
        );
    }
}
