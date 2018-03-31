<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class TagInfo
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $reach;

    /**
     * @var string|null
     */
    private $wikiSummary;

    /**
     * TagInfo constructor.
     *
     * @param string      $name
     * @param null|string $url
     * @param int         $total
     * @param int         $reach
     * @param null|string $wikiSummary
     */
    public function __construct(string $name, ?string $url, int $total, int $reach, ?string $wikiSummary)
    {
        $this->name        = $name;
        $this->url         = $url;
        $this->total       = $total;
        $this->reach       = $reach;
        $this->wikiSummary = $wikiSummary;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getReach(): int
    {
        return $this->reach;
    }

    /**
     * @return null|string
     */
    public function getWikiSummary(): ?string
    {
        return $this->wikiSummary;
    }

    /**
     * @param array $data
     *
     * @return Tag
     */
    public static function fromApi(array $data): self
    {
        return new self(
            $data['name'],
            $data['url'] ?? null,
            $data['total'] ? (int) $data['total'] : 0,
            $data['reach'] ? (int) $data['reach'] : 0,
            $data['wiki']['summary'] ?? null
        );
    }
}
