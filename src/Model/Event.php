<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

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
     * @var \DateTime
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

    /**
     * @param int        $eventId
     * @param string     $title
     * @param \DateTime  $eventDate
     * @param string     $url
     * @param Venue|null $venue
     */
    public function __construct(int $eventId, string $title, \DateTime $eventDate, string $url, ?Venue $venue)
    {
        $this->eventId   = $eventId;
        $this->title     = $title;
        $this->eventDate = $eventDate;
        $this->url       = $url;
        $this->venue     = $venue;
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate(): \DateTime
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

    /**
     * @return Venue|null
     */
    public function getVenue(): ?Venue
    {
        return $this->venue;
    }
}
