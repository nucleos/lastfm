<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\LastFm\Service;

use Nucleos\LastFm\Client\ApiClientInterface;
use Nucleos\LastFm\Model\ArtistInfo;
use Nucleos\LastFm\Util\ApiHelper;

final class LibraryService implements LibraryServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    public function getArtists(string $user, int $limit = 50, int $page = 1): array
    {
        $response = $this->client->unsignedCall('library.getArtists', [
            'user'  => $user,
            'limit' => $limit,
            'page'  => $page,
        ]);

        if (!isset($response['artists']['artist'])) {
            return [];
        }

        return ApiHelper::mapList(
            static function (array $data): ArtistInfo {
                return ArtistInfo::fromApi($data);
            },
            $response['artists']['artist']
        );
    }
}
