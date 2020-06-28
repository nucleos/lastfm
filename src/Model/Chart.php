<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Model;

use DateTime;
use Nucleos\LastFm\Exception\ApiException;

final class Chart
{
    /**
     * @var DateTime
     */
    private $from;

    /**
     * @var DateTime
     */
    private $to;

    public function __construct(DateTime $from, DateTime $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    public function getFrom(): DateTime
    {
        return $this->from;
    }

    public function getTo(): DateTime
    {
        return $this->to;
    }

    /**
     * @throws ApiException
     *
     * @return Chart
     */
    public static function fromApi(array $data): self
    {
        $fromDate = DateTime::createFromFormat('U', $data['from']);

        if (false === $fromDate) {
            throw new ApiException('Error fetching from date');
        }

        $toDate = DateTime::createFromFormat('U', $data['to']);

        if (false === $toDate) {
            throw new ApiException('Error fetching to date');
        }

        return new self($fromDate, $toDate);
    }
}
