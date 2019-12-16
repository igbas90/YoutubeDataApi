<?php


namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;

/**
 * Class SubscriptionsList
 *
 * @method setApiKey(string $key)
 * @method setChannelId($value)
 * @method setId($value)
 * @method setForChannelId($value)
 * @method setMaxResults($value)
 * @method setOnBehalfOfContentOwner($value)
 * @method setOrder($value)
 * @method setPageToken($value)
 * @method setParams(array $params)
 * @method setPart($part)
 * @method setProxy(string $proxy) : Base
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas0404@mail.com>
 */
class SubscriptionsList extends Base
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

    public function getIterator($cloned = false)
    {
        return new ListIterator(($cloned ? $this : clone $this), $this->params['pageToken']);
    }
}