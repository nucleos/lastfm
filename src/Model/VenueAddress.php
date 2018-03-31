<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class VenueAddress
{
    /**
     * @var string|null
     */
    private $street;

    /**
     * @var string|null
     */
    private $postalCode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country;

    /**
     * VenueAddress constructor.
     *
     * @param string|null $street
     * @param string|null $postalCode
     * @param string      $city
     * @param string      $country
     */
    public function __construct(?string $street, ?string $postalCode, string $city, string $country)
    {
        $this->street     = $street;
        $this->postalCode = $postalCode;
        $this->city       = $city;
        $this->country    = $country;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}
