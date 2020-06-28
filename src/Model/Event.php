<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Model;

use DateTimeImmutable;

/**
 * @psalm-immutable
 */
final class Event
{
    /**
     * @var int
     */
    private $eventId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var DateTimeImmutable
     */
    private $eventDate;

    /**
     * @var string
     */
    private $url;

    /**
     * @var Venue|null
     */
    private $venue;

    public function __construct(int $eventId, string $title, DateTimeImmutable $eventDate, string $url, ?Venue $venue)
    {
        $this->eventId   = $eventId;
        $this->title     = $title;
        $this->eventDate = $eventDate;
        $this->url       = $url;
        $this->venue     = $venue;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getEventDate(): DateTimeImmutable
    {
        return $this->eventDate;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getVenue(): ?Venue
    {
        return $this->venue;
    }
}
