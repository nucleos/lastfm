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
use DateTime;
use Symfony\Component\DomCrawler\Crawler;

final class EventListCrawler extends AbstractCrawler implements EventListCrawlerInterface
{
    private const BASE_URL = 'https://www.last.fm/events';

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function getPages(GeoLocation $location, $radius = 100): int
    {
        $node = $this->crawlUrl($location, $radius);

        if (null === $node) {
            return 0;
        }

        $lastNode = $node->filter('.pagination .pagination-page')->last();

        return (int) $lastNode->text();
    }

    /**
     * @param Crawler  $node
     * @param DateTime $datetime
     *
     * @return array
     */
    private function crawlEventListGroup(Crawler $node, DateTime $datetime): array
    {
        return $node->filter('.events-list-item')->each(
            function (Crawler $node) use ($datetime): Event {
                return $this->parseEvent($node, $datetime);
            }
        );
    }

    /**
     * @param GeoLocation $location
     * @param int         $radius
     * @param int         $page
     *
     * @return Crawler|null
     */
    private function crawlUrl(GeoLocation $location, int $radius, int $page = 1): ?Crawler
    {
        $url = static::BASE_URL;
        $url .= '?location_0=Germany';
        $url .= '&location_1='.$location->getLatitude();
        $url .= '&location_2='.$location->getLongitude();
        $url .= '&radius='.($radius*1000);
        $url .= '&page='.$page;

        return $this->crawl($url);
    }
}
