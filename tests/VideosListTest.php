<?php

namespace Igbas90\YoutubeDataApi\Tests;


use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\VideosList;


class VideosListTest extends BaseTestList
{
    /** @var $apiClient Base */
    public $apiClient;
    public $apiKey;
    public $proxy;

    public function setUp(): void
    {
        $this->apiClient = new VideosList();

        $this->proxy = PROXY;
        $this->apiKey = API_KEY;
    }


    public function getLoadParams(): array
    {
        return [
            'id' => VIDEO_ID,
            'maxResults' => 40,
        ];
    }

    public function getDefaultParams(): array
    {
        return (new VideosList())->getParams();
    }

    public function getFailedParams(): array
    {
        return [
            'id' => "ldskhjfhaf",
            'part' => ['default']
        ];
    }
}
