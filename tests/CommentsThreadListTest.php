<?php

namespace Igbas90\YoutubeDataApi\Tests;

use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\CommentsThreadList;

class CommentsThreadListTest extends BaseTestList
{
    /** @var $apiClient Base */
    public $apiClient;
    public $apiKey;
    public $proxy;

    public function setUp(): void
    {
        $this->apiClient = new CommentsThreadList();
        $this->proxy = PROXY;
        $this->apiKey = API_KEY;
    }


    public function getLoadParams(): array
    {
        return [
            'videoId' => VIDEO_ID,
            'maxResults' => 40,
        ];
    }

    public function getDefaultParams(): array
    {
        return (new CommentsThreadList())->getParams();
    }

    public function getFailedParams(): array
    {
        return [
            'id' => "ldskhjfhaf",
            'maxResults' => 120
        ];
    }
}