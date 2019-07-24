<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Core23\LastFm\Model\Event;
use Symfony\Component\DomCrawler\Crawler;

final class ArtistEventCrawler extends AbstractCrawler implements ArtistEventCrawlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getArtistYears(string $artist): array
    {
        $node = $this->crawlUrl($artist);

        if (null === $node) {
            return [];
        }

        $years = $node->filter('.content-top .secondary-nav-item-link')
            ->each(static function (Crawler $node) {
                return (int) trim($node->text());
            })
        ;

        sort($years);
        array_shift($years);

        return $years;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents(string $artist, ?int $year, int $page = 1): array
    {
        $node = $this->crawlUrl($artist, $year, $page);

        if (null === $node) {
            return [];
        }

        return $node->filter('.events-list-item')->each(function (Crawler $node): Event {
            return $this->parseEvent($node);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getYearPages(string $artist, ?int $year): int
    {
        $node = $this->crawlUrl($artist, $year);

        if (null === $node) {
            return 0;
        }

        return $this->countListPages($node);
    }

    /**
     * {@inheritdoc}
     */
    public function getYearCount(string $artist, ?int $year, int $page = 1): int
    {
        $node = $this->crawlUrl($artist, $year, $page);

        if (null === $node) {
            return 0;
        }

        $perPage = $this->countListEvents($node);
        $pages   = $this->countListPages($node);

        if ($pages) {
            $node = $this->crawlUrl($artist, $year, $pages);

            if (null === $node) {
                return $perPage;
            }

            $count = $this->countListEvents($node);

            return ($pages - 1) * $perPage + $count;
        }

        return $perPage;
    }

    private function countListPages(Crawler $node): int
    {
        $pagination = $this->parseString($node->filter('.pagination .pagination-page')->last());

        return $pagination ? (int) preg_replace('/.* of /', '', $pagination) : 1;
    }

    private function countListEvents(Crawler $node): int
    {
        return $node->filter('.events-list-item')->count();
    }

    private function crawlUrl(string $artist, ?int $year = null, int $page = 1): ?Crawler
    {
        $url = 'https://www.last.fm/artist/'.$artist.'/+events/'.($year ?: '');

        return $this->crawl($url, [
            'page' => $page,
        ]);
    }
}
