<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Filter;

use Core23\LastFm\Filter\RangeFilter;
use DateTime;
use PHPUnit\Framework\TestCase;

final class RangeFilterTest extends TestCase
{
    public function testItIsInstantiable(): void
    {
        $filter = new RangeFilter(null, null);

        static::assertSame([
            'foo' => null,
            'bar' => null,
        ], $filter->getQuery('foo', 'bar'));
    }

    public function testGetQuery(): void
    {
        $start = new DateTime();
        $end   = new DateTime('tomorrow');

        $filter = new RangeFilter($start, $end);

        static::assertSame([
            'foo' => $start->getTimestamp(),
            'bar' => $end->getTimestamp(),
        ], $filter->getQuery('foo', 'bar'));
    }
}
