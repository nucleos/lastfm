<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Crawler;

use Nucleos\LastFm\Model\Artist;
use Nucleos\LastFm\Model\EventInfo;
use Nucleos\LastFm\Model\Venue;
use Nucleos\LastFm\Model\VenueAddress;
use Symfony\Component\DomCrawler\Crawler;

final class EventInfoCrawler extends AbstractCrawler implements EventInfoCrawlerInterface
{
    public function getEventInfo(int $id): ?EventInfo
    {
        $node = $this->crawlEvent($id);

        if (null === $node) {
            return null;
        }

        $timeNode = $node->filter('.qa-event-date');

        return new EventInfo(
            $id,
            $this->parseString($node->filter('h1.header-title')) ?? '',
            $this->parseString($node->filter('.qa-event-description'), true),
            $this->parseDate($timeNode->filter('[itemprop="startDate"]')),
            $this->parseDate($timeNode->filter('[itemprop="endDate"]')),
            $this->parseString($node->filter('.qa-event-link a')),
            $this->parseImage($node->filter('.event-poster-preview')),
            $this->parseUrl($node->filter('link[rel="canonical"]')),
            $node->filter('.namespace--events_festival_overview')->count() > 0,
            $this->readVenues($node),
            $this->readArtists($node)
        );
    }

    /**
     * @return Artist[]
     */
    private function readArtists(Crawler $node): array
    {
        $artistNode = $node->filter('.grid-items');

        return $artistNode->filter('.grid-items-item')->each(function (Crawler $node): Artist {
            $image = $this->parseImage($node->filter('.grid-items-cover-image-image img'));

            return new Artist(
                $this->parseString($node->filter('.grid-items-item-main-text')) ?? '',
                null,
                null !== $image ? [$image] : [],
                $this->parseUrl($node->filter('.grid-items-item-main-text a'))
            );
        });
    }

    private function readVenues(Crawler $node): Venue
    {
        $venueNode   = $node->filter('.event-detail');
        $addressNode = $venueNode->filter('.event-detail-address');

        $cityName   = $this->parseString($addressNode->filter('[itemprop="addressLocality"]'));
        $postalCode = $this->parseString($addressNode->filter('[itemprop="postalCode"]'));

        if (null !== $postalCode && null !== $cityName && \strlen($postalCode) > 3) {
            $cityName = trim(str_replace($postalCode, '', $cityName));
        }

        $adress     = new VenueAddress(
            $this->parseString($addressNode->filter('[itemprop="streetAddress"]')),
            $postalCode,
            $cityName,
            $this->parseString($addressNode->filter('[itemprop="addressCountry"]'))
        );

        return new Venue(
            $this->parseString($venueNode->filter('[itemprop="name"]')) ?? '',
            $this->parseUrl($venueNode->filter('.event-detail .qa-event-link a')),
            $this->parseString($venueNode->filter('.event-detail-tel span')),
            $adress
        );
    }

    private function crawlEvent(int $id): ?Crawler
    {
        $url = 'https://www.last.fm/de/event/'.$id;

        return $this->crawl($url);
    }
}
