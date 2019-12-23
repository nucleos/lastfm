<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

use DateTime;

final class EventInfo
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
     * @var string|null
     */
    private $description;

    /**
     * @var DateTime|null
     */
    private $eventDate;

    /**
     * @var DateTime|null
     */
    private $eventEndDate;

    /**
     * @var string|null
     */
    private $eventWebsite;

    /**
     * @var Image|null
     */
    private $image;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var bool
     */
    private $festival;

    /**
     * @var Venue
     */
    private $venue;

    /**
     * @var Artist[]
     */
    private $artists;

    /**
     * @param Artist[] $artists
     */
    public function __construct(
        int $eventId,
        string $title,
        ?string $description,
        ?DateTime $eventDate,
        ?DateTime $eventEndDate,
        ?string $eventWebsite,
        ?Image $image,
        ?string $url,
        bool $festival,
        Venue $venue,
        array $artists
    ) {
        $this->eventId      = $eventId;
        $this->title        = $title;
        $this->description  = $description;
        $this->eventDate    = $eventDate;
        $this->eventEndDate = $eventEndDate;
        $this->eventWebsite = $eventWebsite;
        $this->image        = $image;
        $this->url          = $url;
        $this->festival     = $festival;
        $this->venue        = $venue;
        $this->artists      = $artists;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEventDate(): ?DateTime
    {
        return $this->eventDate;
    }

    public function getEventEndDate(): ?DateTime
    {
        return $this->eventEndDate;
    }

    public function getEventWebsite(): ?string
    {
        return $this->eventWebsite;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function isFestival(): bool
    {
        return $this->festival;
    }

    public function getVenue(): Venue
    {
        return $this->venue;
    }

    /**
     * @return Artist[]
     */
    public function getArtists(): array
    {
        return $this->artists;
    }
}
