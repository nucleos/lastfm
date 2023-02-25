<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Builder;

use DateTime;

final class TrackBuilder
{
    private array $data;

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function create(string $artist, string $track, DateTime $date): self
    {
        return new static([
            'artist'    => $artist,
            'track'     => $track,
            'timestamp' => $date->getTimestamp(),
        ]);
    }

    public function withAlbum(string $album): self
    {
        $this->data['album'] = $album;

        return $this;
    }

    public function withContext(string $context): self
    {
        $this->data['context'] = $context;

        return $this;
    }

    public function withStreamId(int $streamId): self
    {
        $this->data['streamId'] = $streamId;

        return $this;
    }

    public function withChosenByUser(bool $choosenByUser): self
    {
        $this->data['chosenByUser'] = $choosenByUser ? 1 : 0;

        return $this;
    }

    public function withTrackNumber(int $trackNumber): self
    {
        $this->data['trackNumber'] = $trackNumber;

        return $this;
    }

    public function withMbid(string $mbid): self
    {
        $this->data['mbid'] = $mbid;

        return $this;
    }

    public function withAlbumArtist(string $albumArtist): self
    {
        $this->data['albumArtist'] = $albumArtist;

        return $this;
    }

    public function withDuration(int $seconds): self
    {
        $this->data['duration'] = $seconds;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
