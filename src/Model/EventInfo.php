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
     * @var \DateTime
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
     * @var string
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
     * EventInfo constructor.
     *
     * @param int            $eventId
     * @param string         $title
     * @param null|string    $description
     * @param \DateTime      $eventDate
     * @param \DateTime|null $eventEndDate
     * @param null|string    $eventWebsite
     * @param Image|null     $image
     * @param string         $url
     * @param bool           $festival
     * @param Venue          $venue
     * @param Artist[]       $artists
     */
    public function __construct(
        int $eventId,
        string $title,
        ?string $description,
        \DateTime $eventDate,
        ?\DateTime $eventEndDate,
        ?string $eventWebsite,
        ?Image $image,
        string $url,
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
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate(): \DateTime
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
     * @return null|string
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
     * @return string
     */
    public function getUrl(): string
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
