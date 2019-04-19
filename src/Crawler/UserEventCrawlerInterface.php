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
     * @param string $username
     *
     * @return int[]|null
     */
    public function getUserYears(string $username): ?array;

    /**
     * Get all events of a user.
     *
     * @param string   $username
     * @param int|null $year
     * @param int      $page
     *
     * @throws CrawlException
     *
     * @return Event[]|null
     */
    public function getEvents(string $username, ?int $year, int $page = 1): ?array;

    /**
     * Gets the pages for a year.
     *
     * @param string   $username
     * @param int|null $year
     *
     * @return int|null
     */
    public function getYearPages(string $username, ?int $year): ?int;

    /**
     * Gets the event count for a year.
     *
     * @param string   $username
     * @param int|null $year
     * @param int      $page
     *
     * @return int|null
     */
    public function getYearCount(string $username, ?int $year, int $page = 1): ?int;
}
