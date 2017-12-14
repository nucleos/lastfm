What is the LastFM PHP library?
===============================
[![Latest Stable Version](https://poser.pugx.org/core23/lastfm-api/v/stable)](https://packagist.org/packages/core23/lastfm-api)
[![Latest Unstable Version](https://poser.pugx.org/core23/lastfm-api/v/unstable)](https://packagist.org/packages/core23/lastfm-api)
[![License](https://poser.pugx.org/core23/lastfm-api/license)](https://packagist.org/packages/core23/lastfm-api)

[![Build Status](https://travis-ci.org/core23/lastfm-php-api.svg)](http://travis-ci.org/core23/lastfm-php-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/core23/lastfm-php-api/badges/quality-score.png)](https://scrutinizer-ci.com/g/core23/lastfm-php-api/)
[![Coverage Status](https://coveralls.io/repos/core23/lastfm-php-api/badge.svg)](https://coveralls.io/r/core23/lastfm-php-api)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/582dff80-204e-4edb-a719-58cede02a0c5/mini.png)](https://insight.sensiolabs.com/projects/582dff80-204e-4edb-a719-58cede02a0c5)

[![Donate to this project using Flattr](https://img.shields.io/badge/flattr-donate-yellow.svg)](https://flattr.com/profile/core23)
[![Donate to this project using PayPal](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://paypal.me/gripp)

This library provides a wrapper for using the [Last.fm API] inside PHP.

### Installation

```
php composer.phar require core23/lastfm-api

php composer.phar require guzzlehttp/guzzle # if you want to use Guzzle native
php composer.phar require php-http/guzzle6-adapter # if you want to use HTTPlug with Guzzle
```

### Usage
```php
    // Get HTTPlug client and message factory
    $client         = \Http\Discovery\HttpClientDiscovery::find();
    $messageFactory = \Http\Discovery\MessageFactoryDiscovery::find();

    // Create connection
    $connection = new \Core23\LastFm\Connection\HTTPlugConnection($client, $messageFactory);
    
    // Auth user to get a token
    // http://www.last.fm/api/auth/?api_key=API_KEY
    
    // Create a session (with generated token)
    $authApi = new \Core23\LastFm\Service\AuthService($connection);
    $session = $authApi->createSession($token);
    
    $chartApi = new \Core23\LastFm\Service\ChartService($connection);
    $tags = $chartApi->getTopTags(10);
```

### Limitations

Last.fm removed some of their favorite APIs due their relaunch in March 2016. Some of the following removed methods are available via a webcrawler. Please have a look at the `Core23\LastFm\Crawler` package.

```
    Album
        album.getBuylinks
        album.getShouts
        album.share
    Artist
        artist.getEvents
        artist.getPastEvents
        artist.getPodcast
        artist.getShouts
        artist.getTopFans
        artist.share
        artist.shout
    Chart
        chart.getHypedArtists
        chart.getHypedTracks
        chart.getLovedTracks
    Event
        event.attend
        event.getAttendees
        event.getInfo
        event.getShouts
        event.share
        event.shout
    Geo
        geo.getEvents
        geo.getMetroArtistChart
        geo.getMetroHypeArtistChart
        geo.getMetroHypeTrackChart
        geo.getMetroTrackChart
        geo.getMetroUniqueArtistChart
        geo.getMetroUniqueTrackChart
        geo.getMetroWeeklyChartlist
        geo.getMetros
    Group
        group.getHype
        group.getMembers
        group.getWeeklyAlbumChart
        group.getWeeklyArtistChart
        group.getWeeklyChartList
        group.getWeeklyTrackChart
    Library
        library.addAlbum
        library.addArtist
        library.addTrack
        library.getAlbums
        library.getTracks
        library.removeAlbum
        library.removeArtist
        library.removeScrobble
        library.removeTrack
    Playlist
        playlist.addTrack
        playlist.create
    Radio
        radio.getPlaylist
        radio.search
        radio.tune
    Tag
        tag.getWeeklyArtistChart
        tag.search
    Tasteometer
        tasteometer.compare
        tasteometer.compareGroup
    Track
        track.ban
        track.getBuylinks
        track.getFingerprintMetadata
        track.getShouts
        track.getTopFans
        track.share
        track.unban
    User
        user.getArtistTracks
        user.getBannedTracks
        user.getEvents
        user.getNeighbours
        user.getNewReleases
        user.getPastEvents
        user.getPlaylists
        user.getRecentStations
        user.getRecommendedArtists
        user.getRecommendedEvents
        user.getShouts
        user.shout
        user.signUp
        user.terms
    Venue
        venue.getEvents
        venue.getPastEvents
        venue.search

```

[Last.fm API]: http://www.last.fm/api
