<?php


namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;

/**
 * Class SubscriptionsList
 *
 * @method SubscriptionsList setApiKey(string $key)
 * @method SubscriptionsList setChannelId($value)
 * @method SubscriptionsList setId($value)
 * @method SubscriptionsList setForChannelId($value)
 * @method SubscriptionsList setMaxResults($value)
 * @method SubscriptionsList setOnBehalfOfContentOwner($value)
 * @method SubscriptionsList setOrder($value)
 * @method SubscriptionsList setPageToken($value)
 * @method SubscriptionsList setParams(array $params)
 * @method SubscriptionsList setPart($part)
 * @method SubscriptionsList setProxy(string $proxy) : Base
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas040490@gmail.com>
 */
class SubscriptionsList extends Base implements Iteratorable
{
    const PART_CONTENT_DETAILS = 'contentDetails';
    const PART_SNIPPET = 'snippet';
    const PART_ID = 'id';
    const PART_SUBSCRIBER_SNIPPET = 'subscriberSnippet';

    /**
     * @var string
     */
    protected $url = 'https://www.googleapis.com/youtube/v3/subscriptions';

    /**
     * Youtube Data API key
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $params = [
        'part' => ['id', 'contentDetails', 'snippet'],
        'maxResults' => 50,
        'id' => null,
        'channelId' => null,
        'forChannelId' => null,
        'order' => 'relevance',
        'pageToken' => null,
        'onBehalfOfContentOwner' => null
    ];

    public function getAllowedParts(): array
    {
        return [
            self::PART_CONTENT_DETAILS,
            self::PART_SNIPPET,
            self::PART_ID,
            self::PART_SUBSCRIBER_SNIPPET
        ];
    }

    /**
     * @param boolean $cloned
     * @return ListIterator|\Iterator
     */
    public function getIterator($cloned = false)
    {
        return new ListIterator(($cloned ? $this : clone $this), $this->params['pageToken']);
    }
}
