<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class NowPlaying
{
    /**
     * @var string
     */
    private $artist;

    /**
     * @var string
     */
    private $track;

    /**
     * @var string
     */
    private $album;

    /**
     * @var int|null
     */
    private $trackNumber;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @var string|null
     */
    private $mbid;

    /**
     * @var string|null
     */
    private $duration;

    /**
     * @var string|null
     */
    private $albumArtist;

    /**
     * @param string $artist
     * @param string $track
     */
    public function __construct(string $artist, string $track)
    {
        $this->artist = $artist;
        $this->track  = $track;
    }

    /**
     * @param string $album
     */
    public function setAlbum(string $album): void
    {
        $this->album = $album;
    }

    /**
     * @param int|null $trackNumber
     */
    public function setTrackNumber(?int $trackNumber): void
    {
        $this->trackNumber = $trackNumber;
    }

    /**
     * @param string|null $context
     */
    public function setContext(?string $context): void
    {
        $this->context = $context;
    }

    /**
     * @param string|null $mbid
     */
    public function setMbid(?string $mbid): void
    {
        $this->mbid = $mbid;
    }

    /**
     * @param string|null $duration
     */
    public function setDuration(?string $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @param string|null $albumArtist
     */
    public function setAlbumArtist(?string $albumArtist): void
    {
        $this->albumArtist = $albumArtist;
    }

    /**
     * @return array
     */
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
