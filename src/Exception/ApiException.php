<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Exception;

final class ApiException extends \Exception
{
    /**
     * ApiException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getCode().': '.$this->getMessage();
    }
}
