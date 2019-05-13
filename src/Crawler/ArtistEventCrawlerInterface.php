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
     * @param string $artist
     *
     * @return int[]
     */
    public function getArtistYears(string $artist): array;

    /**
     * Get all events of an artist.
     *
     * @param string   $artist
     * @param int|null $year
     * @param int      $page
     *
     * @throws CrawlException
     *
     * @return Event[]
     */
    public function getEvents(string $artist, ?int $year, int $page = 1): array;

    /**
     * Gets the pages for a year.
     *
     * @param string   $artist
     * @param int|null $year
     *
     * @return int
     */
    public function getYearPages(string $artist, ?int $year): int;

    /**
     * Gets the event count for a year.
     *
     * @param string   $artist
     * @param int|null $year
     * @param int      $page
     *
     * @return int
     */
    public function getYearCount(string $artist, ?int $year, int $page = 1): int;
}
