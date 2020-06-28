<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Util;

final class ApiHelper
{
    /**
     * Cleans the api response, so that you always get a list of elements.
     */
    public static function mapList(callable $callback, array $data): array
    {
        if (!isset($data[0])) {
            $data = [$data];
        }

        return array_map($callback, $data);
    }
}
