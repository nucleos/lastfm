<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Core23\LastFm\Model\Event;
use Core23\LastFm\Model\GeoLocation;

interface EventListCrawlerInterface
{
    /**
     * Get all future events.
     *
     * @param int $radius in KM
     *
     * @return Event[]
     */
    public function getEvents(GeoLocation $location, $radius = 100, int $page = 1): array;

    /**
     * Gets the number of pages for a event list.
     *
     * @param int $radius
     */
    public function getPages(GeoLocation $location, $radius = 100): int;
}
