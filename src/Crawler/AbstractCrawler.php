<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Core23\LastFm\Connection\ConnectionInterface;
use Core23\LastFm\Model\Image;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractCrawler
{
    public const URL_PREFIX = 'http://last.fm';

    public const NEWLINE = "\n";

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
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
     * @return Crawler|null
     */
    final protected function crawl(string $url): ?Crawler
    {
        if ($content = $this->connection->getPageBody($url)) {
            return new Crawler($content);
        }

        return null;
    }

    /**
     * Parses a url node.
     *
     * @param Crawler $node
     * @param string  $attr
     *
     * @return string|null
     */
    final protected function parseUrl(Crawler $node, string $attr = 'href'): ?string
    {
        if (0 === $node->count()) {
            return null;
        }

        if ($url = $node->attr($attr)) {
            return preg_replace('/^\//', static::URL_PREFIX.'/', $url);
        }

        return null;
    }

    /**
     * Parses an image node.
     *
     * @param Crawler $node
     *
     * @return Image|null
     */
    final protected function parseImage(Crawler $node): ?Image
    {
        $src = $this->parseUrl($node, 'src');

        if (!$src) {
            return null;
        }

        return new Image($src);
    }

    /**
     * Parses a string node.
     *
     * @param Crawler $node
     * @param bool    $multiline
     *
     * @return string|null
     */
    final protected function parseString(Crawler $node, bool $multiline = false): ?string
    {
        if (0 === $node->count()) {
            return null;
        }

        $content = $node->attr('content');

        if (null === $content) {
            if ($multiline) {
                $content = $node->html();
                $content = (string) preg_replace('/<p[^>]*?>/', '', $content);
                $content = str_replace('</p>', static::NEWLINE, $content);
                $content = (string) preg_replace('/<br\s?\/?>/i', static::NEWLINE, $content);
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
    final protected function parseDate(Crawler $node): ?\DateTime
    {
        $content = $this->parseString($node);

        if (null !== $content) {
            return new \DateTime($content);
        }

        return null;
    }
}
