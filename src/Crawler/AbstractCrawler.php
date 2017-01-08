<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Core23\LastFm\Connection\ConnectionInterface;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractCrawler
{
    const URL_PREFIX = 'http://last.fm';

    const NEWLINE = "\n";

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * AbstractService constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Crawles a url.
     *
     * @param string $url
     *
     * @return Crawler
     */
    final protected function crawl($url)
    {
        $content = $this->connection->loadPage($url);

        return new Crawler($content);
    }

    /**
     * Parses a url node.
     *
     * @param Crawler $node
     * @param string  $attr
     *
     * @return null|string
     */
    final protected function parseUrl(Crawler $node, $attr = 'href')
    {
        if ($node == null || $node->count() === 0) {
            return;
        }

        if ($url = $node->attr($attr)) {
            return preg_replace('/^\//', static::URL_PREFIX.'/', $url);
        }

        return;
    }

    /**
     * Parses an image node.
     *
     * @param Crawler $node
     *
     * @return null|string
     */
    final protected function parseImage(Crawler $node)
    {
        return $this->parseUrl($node, 'src');
    }

    /**
     * Parses a string node.
     *
     * @param Crawler $node
     * @param bool    $multiline
     *
     * @return null|string
     */
    final protected function parseString(Crawler $node, $multiline = false)
    {
        if ($node == null || $node->count() === 0) {
            return;
        }

        $content = $node->attr('content');

        if (!$content) {
            if ($multiline) {
                $content = $node->html();
                $content = preg_replace('/<p[^>]*?>/', '', $content);
                $content = str_replace('</p>', static::NEWLINE, $content);
                $content = preg_replace('/<br\s?\/?>/i', static::NEWLINE, $content);
            } else {
                $content = $node->text();
            }
        }

        return trim(strip_tags($content));
    }

    /**
     * Parses a date note.
     *
     * @param Crawler $node
     *
     * @return \DateTime|null
     */
    final protected function parseDate(Crawler $node)
    {
        $content = $this->parseString($node);

        if ($content) {
            return new \DateTime($content);
        }

        return;
    }
}
