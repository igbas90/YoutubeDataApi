<?php

namespace Igbas90\YoutubeDataApi\Tests;


use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\ChannelsList;
use Igbas90\YoutubeDataApi\Services\VideoCategoriesList;


class VideoCategoriesListTest extends BaseTestList
{
    /** @var $apiClient Base */
    public $apiClient;
    public $apiKey;
    public $proxy;

    public function setUp(): void
    {
        $this->apiClient = new VideoCategoriesList();

        $this->proxy = PROXY;
        $this->apiKey = API_KEY;
    }


    public function getLoadParams(): array
    {
        return [
            'id' => 1,
        ];
    }

    public function getDefaultParams(): array
    {
        return (new VideoCategoriesList())->getParams();
    }

    public function getFailedParams(): array
    {
        return [
            'id' => "ldskhjfhaf",
            'part' => ['statistics']
        ];
    }
}
