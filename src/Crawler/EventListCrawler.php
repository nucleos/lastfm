<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Symfony\Component\DomCrawler\Crawler;

final class EventListCrawler extends AbstractCrawler
{
    /**
     * @param string $username
     *
     * @return int[]|null
     */
    public function getUserYears(string $username): ? array
    {
        $node = $this->crawlEventList($username);

        if (null === $node) {
            return null;
        }

        $years = $node->filter('.content-top .secondary-nav-item-link')
            ->each(function (Crawler $node) {
                return (int) trim($node->text());
            });

        sort($years);
        array_shift($years);

        return $years;
    }

    /**
     * Get all events of a user.
     *
     * @param string $username
     * @param int    $year
     * @param int    $page
     *
     * @return array|null
     */
    public function getEvents(string $username, int $year, int $page = 1): ? array
    {
        $node = $this->crawlEventList($username, $year, $page);

        if (null === $node) {
            return null;
        }

        return $node->filter('.events-list-item')->each(function (Crawler $node): array {
            $eventNode = $node->filter('.events-list-item-event--title a');

            $url = $this->parseUrl($eventNode);
            $id = preg_replace('/.*\/(\d+)+.*/', '$1', $url);

            return array(
                'eventId' => (int) $id,
                'title'   => $this->parseString($eventNode),
                'time'    => new \DateTime($node->filter('time')->attr('datetime')),
                'url'     => $url,
            );
        });
    }

    /**
     * Gets the pages for a year.
     *
     * @param string $username
     * @param int    $year
     *
     * @return int|null
     */
    public function getYearPages(string $username, int $year): ? int
    {
        $node = $this->crawlEventList($username, $year);

        if (null === $node) {
            return null;
        }

        return $this->countListPages($node);
    }

    /**
     * Gets the event count for a year.
     *
     * @param string $username
     * @param int    $year
     * @param int    $page
     *
     * @return int|null
     */
    public function getYearCount(string $username, int $year, int $page = 1): ? int
    {
        $node = $this->crawlEventList($username, $year, $page);

        if (null === $node) {
            return null;
        }

        $perPage = $this->countListEvents($node);
        $pages   = $this->countListPages($node);

        if ($pages) {
            $node  = $this->crawlEventList($username, $year, $pages);
            $count = $this->countListEvents($node);

            return ($pages - 1) * $perPage + $count;
        }

        return $perPage;
    }

    /**
     * @param Crawler $node
     *
     * @return int
     */
    private function countListPages(Crawler $node): int
    {
        $pagination = $this->parseString($node->filter('.pagination .pages'));

        return $pagination ? (int) preg_replace('/.* of /', '', $pagination) : 1;
    }

    /**
     * @param Crawler $node
     *
     * @return int
     */
    private function countListEvents(Crawler $node): int
    {
        return $node->filter('.events-list-item')->count();
    }

    /**
     * @param string $username
     * @param int    $year
     * @param int    $page
     *
     * @return Crawler|null
     */
    private function crawlEventList(string $username, int $year = 2000, int $page = 1): ? Crawler
    {
        $url = 'http://www.last.fm/user/'.$username.'/events/'.$year.'?page='.$page;

        return $this->crawl($url);
    }
}
