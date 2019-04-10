<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Exception;

use Core23\LastFm\Exception\ApiException;
use PHPUnit\Framework\TestCase;

class ApiExceptionTest extends TestCase
{
    public function testToString(): void
    {
        $exception = new ApiException('My error', 304);

        $this->assertSame('304: My error', $exception->__toString());
    }
}
