<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Model;

final class NowPlaying
{
    private string $artist;

    private string $track;

    private ?string $album = null;

    private ?int $trackNumber = null;

    private ?string $context = null;

    private ?string $mbid = null;

    private ?string $duration = null;

    private ?string $albumArtist = null;

    public function __construct(string $artist, string $track)
    {
        $this->artist = $artist;
        $this->track  = $track;
    }

    public function setAlbum(string $album): void
    {
        $this->album = $album;
    }

    public function setTrackNumber(?int $trackNumber): void
    {
        $this->trackNumber = $trackNumber;
    }

    public function setContext(?string $context): void
    {
        $this->context = $context;
    }

    public function setMbid(?string $mbid): void
    {
        $this->mbid = $mbid;
    }

    public function setDuration(?string $duration): void
    {
        $this->duration = $duration;
    }

    public function setAlbumArtist(?string $albumArtist): void
    {
        $this->albumArtist = $albumArtist;
    }

    public function toArray(): array
    {
        return [
            'artist'      => $this->artist,
            'track'       => $this->track,
            'album'       => $this->album,
            'trackNumber' => $this->trackNumber,
            'context'     => $this->context,
            'mbid'        => $this->mbid,
            'duration'    => $this->duration,
            'albumArtist' => $this->albumArtist,
        ];
    }
}
