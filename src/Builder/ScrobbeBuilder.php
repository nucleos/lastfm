<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Builder;

final class ScrobbeBuilder
{
    /**
     * @var array
     */
    private $tracks;

    private function __construct()
    {
    }

    /**
     * @return ScrobbeBuilder
     */
    public function create(): self
    {
        $this->tracks = [];
    }

    /**
     * @param TrackBuilder $builder
     *
     * @return ScrobbeBuilder
     */
    public function addTrack(TrackBuilder $builder): self
    {
        $this->tracks[] = $builder->getData();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->tracks);
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        $query = [];

        $tracks = $this->tracks;

        foreach ($tracks as $i => $track) {
            $keys = array_keys($track);

            foreach ($keys as $key) {
                $query[sprintf('%s[%s]', $key, $i)] = $tracks[$i][$key];
            }
        }

        return $query;
    }
}
