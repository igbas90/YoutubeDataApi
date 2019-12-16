<?php

namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;

/**
 * Class CommentsThreadList
 *
 * @method setApiKey(string $key)
 * @method setChannelId($value)
 * @method setId($value)
 * @method setMaxResults($value)
 * @method setOrder($value)
 * @method setPageToken($value)
 * @method setParams(array $params)
 * @method setPart($part)
 * @method setProxy(string $proxy) : Base
 * @method setSearchTerms($value)
 * @method setVideoId($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas0404@mail.com>
 */
class CommentsThreadList extends Base
{
    const PART_SNIPPET = 'snippet';
    const PART_ID = 'id';
    const PART_REPLIES = 'replies';

    /**
     * @var string
     */
    protected $url = 'https://www.googleapis.com/youtube/v3/commentThreads';
    /**
     * @var array
     */
    protected $params = [
        'part' => [self::PART_ID, self::PART_REPLIES, self::PART_SNIPPET],
        'id' => null,
        'maxResults' => 100,
        'channelId' => null,
        'videoId' => null,
        'order' => 'time',
        'pageToken' => null,
        'searchTerms' => null,
    ];

    public function getAllowedParts(): array
    {
        return [
            self::PART_ID,
            self::PART_REPLIES,
            self::PART_SNIPPET
        ];
    }

    public function getIterator($cloned = false)
    {
        return new ListIterator(($cloned ? $this : clone $this), $this->params['pageToken']);
    }
}