<?php

namespace Igbas90\YoutubeDataApi\Tests;

use Igbas90\YoutubeDataApi\Services\PlaylistItemsList;
use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Tests\traits\Iteration;

class PlaylistItemsListTest extends BaseTestList
{
    use Iteration;

    /** @var $apiClient Base */
    public $apiClient;
    public $apiKey;
    public $proxy;

    public function setUp(): void
    {
        $this->apiClient = new PlaylistItemsList();
        $this->proxy = PROXY;
        $this->apiKey = API_KEY;
    }


    public function getLoadParams(): array
    {
        return [
            'playlistId' => PLAYLIST_ID,
            'maxResults' => 40,
        ];
    }

    public function getDefaultParams(): array
    {
        return (new PlaylistItemsList())->getParams();
    }

    public function getFailedParams(): array
    {
        return [
            'id' => "ldskhjfhaf",
            'part' => ['default']
        ];
    }
}
