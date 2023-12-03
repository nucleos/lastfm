<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Tests\Exception;

use Nucleos\LastFm\Exception\ApiException;
use PHPUnit\Framework\TestCase;

final class ApiExceptionTest extends TestCase
{
    public function testToString(): void
    {
        $exception = new ApiException('My error', 304);

        self::assertSame('304: My error', $exception->__toString());
    }
}
