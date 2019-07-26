<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Core23\LastFm\Exception\CrawlException;
use Core23\LastFm\Model\Event;

interface ArtistEventCrawlerInterface
{
    /**
     * @return int[]
     */
    public function getArtistYears(string $artist): array;

    /**
     * Get all events of an artist.
     *
     * @throws CrawlException
     *
     * @return Event[]
     */
    public function getEvents(string $artist, ?int $year, int $page = 1): array;

    /**
     * Gets the pages for a year.
     */
    public function getYearPages(string $artist, ?int $year): int;

    /**
     * Gets the event count for a year.
     */
    public function getYearCount(string $artist, ?int $year, int $page = 1): int;
}
