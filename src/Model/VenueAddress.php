<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Model;

/**
 * @psalm-immutable
 */
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
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $country;

    public function __construct(?string $street, ?string $postalCode, ?string $city, ?string $country)
    {
        $this->street     = $street;
        $this->postalCode = $postalCode;
        $this->city       = $city;
        $this->country    = $country;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }
}
