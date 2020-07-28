<?php

namespace Igbas90\YoutubeDataApi\Tests;

use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\SubscriptionsList;

class SubscriptionsListTest extends BaseTestList
{
    /** @var $apiClient Base */
    public $apiClient;
    public $apiKey;
    public $proxy;

    public function setUp(): void
    {
        $this->apiClient = new SubscriptionsList();
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
        return (new SubscriptionsList())->getParams();
    }

    public function getFailedParams(): array
    {
        return [
            'id' => "ldskhjfhaf",
            'part' => ['default']
        ];
    }
}
