<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Builder;

use DateTime;

final class TrackBuilder
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string   $artist
     * @param string   $track
     * @param DateTime $date
     *
     * @return TrackBuilder
     */
    public static function create(string $artist, string $track, DateTime $date): self
    {
        return new static([
            'artist'    => $artist,
            'track'     => $track,
            'timestamp' => $date->getTimestamp(),
        ]);
    }

    /**
     * @param string $album
     *
     * @return TrackBuilder
     */
    public function withAlbum(string $album): self
    {
        $this->data['album'] = $album;

        return $this;
    }

    /**
     * @param string $context
     *
     * @return TrackBuilder
     */
    public function withContext(string $context): self
    {
        $this->data['context'] = $context;

        return $this;
    }

    /**
     * @param int $streamId
     *
     * @return TrackBuilder
     */
    public function withStreamId(int $streamId): self
    {
        $this->data['streamId'] = $streamId;

        return $this;
    }

    /**
     * @param bool $choosenByUser
     *
     * @return TrackBuilder
     */
    public function withChosenByUser(bool $choosenByUser): self
    {
        $this->data['chosenByUser'] = $choosenByUser ? 1 : 0;

        return $this;
    }

    /**
     * @param int $trackNumber
     *
     * @return TrackBuilder
     */
    public function withTrackNumber(int $trackNumber): self
    {
        $this->data['trackNumber'] = $trackNumber;

        return $this;
    }

    /**
     * @param string $mbid
     *
     * @return TrackBuilder
     */
    public function withMbid(string $mbid): self
    {
        $this->data['mbid'] = $mbid;

        return $this;
    }

    /**
     * @param string $albumArtist
     *
     * @return TrackBuilder
     */
    public function withAlbumArtist(string $albumArtist): self
    {
        $this->data['albumArtist'] = $albumArtist;

        return $this;
    }

    /**
     * @param int $seconds
     *
     * @return TrackBuilder
     */
    public function withDuration(int $seconds): self
    {
        $this->data['duration'] = $seconds;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
