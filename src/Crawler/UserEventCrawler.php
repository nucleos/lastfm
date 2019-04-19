<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Symfony\Component\DomCrawler\Crawler;

final class UserEventCrawler extends AbstractCrawler implements UserEventCrawlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserYears(string $username): ?array
    {
        $node = $this->crawlUrl($username);

        if (null === $node) {
            return null;
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
    public function getEvents(string $username, ?int $year, int $page = 1): ?array
    {
        $node = $this->crawlUrl($username, $year, $page);

        if (null === $node) {
            return null;
        }

        return $this->crawlEventList($node);
    }

    /**
     * {@inheritdoc}
     */
    public function getYearPages(string $username, ?int $year): ?int
    {
        $node = $this->crawlUrl($username, $year);

        if (null === $node) {
            return null;
        }

        return $this->countListPages($node);
    }

    /**
     * {@inheritdoc}
     */
    public function getYearCount(string $username, ?int $year, int $page = 1): ?int
    {
        $node = $this->crawlUrl($username, $year, $page);

        if (null === $node) {
            return null;
        }

        $perPage = $this->countListEvents($node);
        $pages   = $this->countListPages($node);

        if ($pages) {
            $node = $this->crawlUrl($username, $year, $pages);

            if (null === $node) {
                return $perPage;
            }

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
     * @param string   $username
     * @param int|null $year
     * @param int      $page
     *
     * @return Crawler|null
     */
    private function crawlUrl(string $username, ?int $year = null, int $page = 1): ?Crawler
    {
        $url = 'http://www.last.fm/user/'.$username.'/events/'.($year ?: '').'?page='.$page;

        return $this->crawl($url);
    }
}
