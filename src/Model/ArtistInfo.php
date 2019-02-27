<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class ArtistInfo
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
     * @var Image[]
     */
    private $image;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var int
     */
    private $playcount;

    /**
     * @var string|null
     */
    private $bioSummary;

    /**
     * @var string|null
     */
    private $bioContent;

    /**
     * @var int
     */
    private $tagcount;

    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @param string      $name
     * @param string|null $mbid
     * @param Image[]     $image
     * @param string|null $url
     * @param int         $playcount
     * @param string|null $bioSummary
     * @param string|null $bioContent
     * @param int         $tagcount
     * @param Tag[]       $tags
     */
    public function __construct(
        string $name,
        ?string $mbid,
        array $image,
        ?string $url,
        int $playcount,
        ?string $bioSummary,
        ?string $bioContent,
        int $tagcount,
        array $tags
    ) {
        $this->name       = $name;
        $this->mbid       = $mbid;
        $this->image      = $image;
        $this->url        = $url;
        $this->playcount  = $playcount;
        $this->bioSummary = $bioSummary;
        $this->bioContent = $bioContent;
        $this->tagcount   = $tagcount;
        $this->tags       = $tags;
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
     * @return Image[]
     */
    public function getImage(): array
    {
        return $this->image;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getPlaycount(): int
    {
        return $this->playcount;
    }

    /**
     * @return string|null
     */
    public function getBioSummary(): ?string
    {
        return $this->bioSummary;
    }

    /**
     * @return string|null
     */
    public function getBioContent(): ?string
    {
        return $this->bioContent;
    }

    /**
     * @return int
     */
    public function getTagcount(): int
    {
        return $this->tagcount;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $data
     *
     * @return ArtistInfo
     */
    public static function fromApi(array $data): self
    {
        $images = [];
        $tags   = [];

        if (\array_key_exists('image', $data)) {
            foreach ((array) $data['image'] as $image) {
                $images[] = new Image($image['#text']);
            }
        }

        if (\array_key_exists('tags', $data) && \array_key_exists('tag', $data['tags'])) {
            foreach ((array) $data['tags']['tag'] as $tag) {
                $tags[] = Tag::fromApi($tag);
            }
        }

        return new self(
            $data['name'],
            $data['mbid'] ?? null,
            $images,
            $data['url'] ?? null,
            isset($data['playcount']) ? (int) $data['playcount'] : 0,
            $data['bio']['summary'] ?? null,
            $data['bio']['content'] ?? null,
            isset($data['tagcount']) ? (int) $data['tagcount'] : 0,
            $tags
        );
    }
}
