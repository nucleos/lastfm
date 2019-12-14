<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Filter;

use DateTime;

final class RangeFilter
{
    /**
     * @var DateTime|null
     */
    private $start;

    /**
     * @var DateTime|null
     */
    private $end;

    public function __construct(?DateTime $start, ?DateTime $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function getQuery(string $startKey, string $endKey): array
    {
        return [
            $startKey => null !== $this->start ? $this->start->getTimestamp() : null,
            $endKey   => null !== $this->end ? $this->end->getTimestamp() : null,
        ];
    }
}
