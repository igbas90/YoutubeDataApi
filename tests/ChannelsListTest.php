<?php

namespace Igbas90\YoutubeDataApi\Tests;


use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\ChannelsList;

class ChannelsListTest extends BaseTestList
{
    /** @var $apiClient Base */
    public $apiClient;
    public $apiKey;
    public $proxy;

    public function setUp(): void
    {
        $this->apiClient = new ChannelsList();
        $this->proxy = PROXY;
        $this->apiKey = API_KEY;
    }


    public function getLoadParams(): array
    {
        return [
            'id' => CHANNEL_ID,
            'maxResults' => 40,
        ];
    }

    public function getDefaultParams(): array
    {
        return (new ChannelsList())->getParams();
    }

    public function getFailedParams(): array
    {
        return [
            'id' => "ldskhjfhaf",
            'maxResults' => 120
        ];
    }
}