<?php

namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;

/**
 * Class CommentsThreadList
 *
 * @method CommentsThreadList setApiKey(string $key)
 * @method CommentsThreadList setChannelId($value)
 * @method CommentsThreadList setId($value)
 * @method CommentsThreadList setMaxResults($value)
 * @method CommentsThreadList setOrder($value)
 * @method CommentsThreadList setPageToken($value)
 * @method CommentsThreadList setParams(array $params)
 * @method CommentsThreadList setPart($part)
 * @method CommentsThreadList setProxy(string $proxy) : Base
 * @method CommentsThreadList setSearchTerms($value)
 * @method CommentsThreadList setVideoId($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas040490@gmail.com>
 */
class CommentsThreadList extends Base implements Iteratorable
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

    /**
     * @param bool $cloned
     * @return ListIterator|\Iterator
     */
    public function getIterator($cloned = false)
    {
        return new ListIterator(($cloned ? $this : clone $this), $this->params['pageToken']);
    }
}
