<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Exception;

use Exception;

final class ApiException extends Exception
{
    public function __toString()
    {
        return $this->getCode().': '.$this->getMessage();
    }
}
