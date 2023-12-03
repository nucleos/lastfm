<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Filter;

use Nucleos\LastFm\Filter\Period;
use PHPUnit\Framework\TestCase;

final class PeriodTest extends TestCase
{
    public function testOverall(): void
    {
        self::assertSame('overall', Period::overall()->getValue());
    }

    public function testWeek(): void
    {
        self::assertSame('7day', Period::week()->getValue());
    }

    public function testMonth(): void
    {
        self::assertSame('1month', Period::month()->getValue());
    }

    public function testQuarterYear(): void
    {
        self::assertSame('3month', Period::quarterYear()->getValue());
    }

    public function testHalfYear(): void
    {
        self::assertSame('6month', Period::halfYear()->getValue());
    }

    public function testYear(): void
    {
        self::assertSame('12month', Period::year()->getValue());
    }
}
