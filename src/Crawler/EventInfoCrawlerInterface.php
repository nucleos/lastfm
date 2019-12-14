<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Crawler;

use Core23\LastFm\Exception\CrawlException;
use Core23\LastFm\Model\EventInfo;

interface EventInfoCrawlerInterface
{
    /**
     * Get all event information.
     *
     * @throws CrawlException
     */
    public function getEventInfo(int $id): ?EventInfo;
}
