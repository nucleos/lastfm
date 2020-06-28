<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Filter;

final class Period
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return Period
     */
    public static function overall(): self
    {
        return new self('overall');
    }

    /**
     * @return Period
     */
    public static function week(): self
    {
        return new self('7day');
    }

    /**
     * @return Period
     */
    public static function month(): self
    {
        return new self('1month');
    }

    /**
     * @return Period
     */
    public static function quarterYear(): self
    {
        return new self('3month');
    }

    /**
     * @return Period
     */
    public static function halfYear(): self
    {
        return new self('6month');
    }

    /**
     * @return Period
     */
    public static function year(): self
    {
        return new self('12month');
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
