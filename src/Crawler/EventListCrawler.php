<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Crawler;

use DateTime;
use Nucleos\LastFm\Model\Event;
use Nucleos\LastFm\Model\GeoLocation;
use Symfony\Component\DomCrawler\Crawler;

final class EventListCrawler extends AbstractCrawler implements EventListCrawlerInterface
{
    private const BASE_URL = 'https://www.last.fm/events';

    public function getEvents(GeoLocation $location, $radius = 100, int $page = 1): array
    {
        $node = $this->crawlUrl($location, $radius, $page);

        if (null === $node) {
            return [];
        }

        $resultList = [];

        $node->filter('.page-content section')->each(function (Crawler $node) use (&$resultList) {
            $headingNode = $node->filter('.group-heading');

            $datetime = new DateTime(trim($headingNode->text()));

            $resultList = array_merge($resultList, $this->crawlEventListGroup($node, $datetime));
        });

        return $resultList;
    }

    public function getPages(GeoLocation $location, $radius = 100): int
    {
        $node = $this->crawlUrl($location, $radius);

        if (null === $node) {
            return 0;
        }

        $lastNode = $node->filter('.pagination .pagination-page')->last();

        if (0 === $lastNode->count()) {
            return 0;
        }

        return (int) $lastNode->text();
    }

    private function crawlEventListGroup(Crawler $node, DateTime $datetime): array
    {
        return $node->filter('.events-list-item')->each(
            function (Crawler $node) use ($datetime): Event {
                return $this->parseEvent($node, $datetime);
            }
        );
    }

    private function crawlUrl(GeoLocation $location, int $radius, int $page = 1): ?Crawler
    {
        $url = static::BASE_URL;

        return $this->crawl($url, [
            'location_0' => 'Germany',
            'location_1' => $location->getLatitude(),
            'location_2' => $location->getLongitude(),
            'radius'     => $radius*1000,
            'page'       => $page,
        ]);
    }
}
