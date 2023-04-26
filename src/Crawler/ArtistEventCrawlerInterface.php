<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Crawler;

use Nucleos\LastFm\Exception\CrawlException;
use Nucleos\LastFm\Model\Event;

interface ArtistEventCrawlerInterface
{
    /**
     * @return int[]
     *
     * @throws CrawlException
     */
    public function getArtistYears(string $artist): array;

    /**
     * Get all events of an artist.
     *
     * @return Event[]
     *
     * @throws CrawlException
     */
    public function getEvents(string $artist, ?int $year, int $page = 1): array;

    /**
     * Gets the pages for a year.
     *
     * @throws CrawlException
     */
    public function getYearPages(string $artist, ?int $year): int;

    /**
     * Gets the event count for a year.
     *
     * @throws CrawlException
     */
    public function getYearCount(string $artist, ?int $year, int $page = 1): int;
}
