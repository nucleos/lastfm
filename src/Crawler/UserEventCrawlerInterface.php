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

interface UserEventCrawlerInterface
{
    /**
     * @return int[]
     */
    public function getUserYears(string $username): array;

    /**
     * Get all events of a user.
     *
     * @throws CrawlException
     *
     * @return Event[]
     */
    public function getEvents(string $username, ?int $year, int $page = 1): array;

    /**
     * Gets the pages for a year.
     */
    public function getYearPages(string $username, ?int $year): int;

    /**
     * Gets the event count for a year.
     */
    public function getYearCount(string $username, ?int $year, int $page = 1): int;
}
