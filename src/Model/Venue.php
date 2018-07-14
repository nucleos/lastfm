<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class Venue
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var string|null
     */
    private $telephone;

    /**
     * @var VenueAddress
     */
    private $address;

    /**
     * @param string       $name
     * @param string|null  $url
     * @param null|string  $telephone
     * @param VenueAddress $address
     */
    public function __construct(string $name, ?string $url, ?string $telephone, VenueAddress $address)
    {
        $this->name      = $name;
        $this->url       = $url;
        $this->telephone = $telephone;
        $this->address   = $address;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return null|string
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @return VenueAddress
     */
    public function getAddress(): VenueAddress
    {
        return $this->address;
    }
}
