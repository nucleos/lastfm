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
use Nucleos\LastFm\Model\GeoLocation;

interface EventListCrawlerInterface
{
    /**
     * Get all future events.
     *
     * @param int $radius in KM
     *
     * @throws CrawlException
     *
     * @return Event[]
     */
    public function getEvents(GeoLocation $location, $radius = 100, int $page = 1): array;

    /**
     * Gets the number of pages for a event list.
     *
     * @param int $radius
     *
     * @throws CrawlException
     */
    public function getPages(GeoLocation $location, $radius = 100): int;
}
