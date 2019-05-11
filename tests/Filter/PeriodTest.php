<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Filter;

use Core23\LastFm\Filter\Period;
use PHPUnit\Framework\TestCase;

class PeriodTest extends TestCase
{
    public function testOverall(): void
    {
        static::assertSame('overall', Period::overall()->getValue());
    }

    public function testWeek(): void
    {
        static::assertSame('7day', Period::week()->getValue());
    }

    public function testMonth(): void
    {
        static::assertSame('1month', Period::month()->getValue());
    }

    public function testQuarterYear(): void
    {
        static::assertSame('3month', Period::quarterYear()->getValue());
    }

    public function testHalfYear(): void
    {
        static::assertSame('6month', Period::halfYear()->getValue());
    }

    public function testYear(): void
    {
        static::assertSame('12month', Period::year()->getValue());
    }
}
