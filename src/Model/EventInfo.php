<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

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
     * @var \DateTime|null
     */
    private $eventDate;

    /**
     * @var \DateTime|null
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
     * @param int            $eventId
     * @param string         $title
     * @param string|null    $description
     * @param \DateTime|null $eventDate
     * @param \DateTime|null $eventEndDate
     * @param string|null    $eventWebsite
     * @param Image|null     $image
     * @param string|null    $url
     * @param bool           $festival
     * @param Venue          $venue
     * @param Artist[]       $artists
     */
    public function __construct(
        int $eventId,
        string $title,
        ?string $description,
        ?\DateTime $eventDate,
        ?\DateTime $eventEndDate,
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return \DateTime|null
     */
    public function getEventDate(): ?\DateTime
    {
        return $this->eventDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getEventEndDate(): ?\DateTime
    {
        return $this->eventEndDate;
    }

    /**
     * @return string|null
     */
    public function getEventWebsite(): ?string
    {
        return $this->eventWebsite;
    }

    /**
     * @return Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isFestival(): bool
    {
        return $this->festival;
    }

    /**
     * @return Venue
     */
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
