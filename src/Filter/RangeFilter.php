<?php

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

    /**
     * @param DateTime|null $start
     * @param DateTime|null $end
     */
    public function __construct(?DateTime $start, ?DateTime $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    /**
     * @param string $startKey
     * @param string $endKey
     *
     * @return array
     */
    public function getQuery(string $startKey, string $endKey): array
    {
        return [
            $startKey => $this->start ? $this->start->getTimestamp() : null,
            $endKey   => $this->end ? $this->end->getTimestamp() : null,
        ];
    }
}
