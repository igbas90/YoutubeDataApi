<?php


namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;

/**
 * Class VideosList
 *
 * @method VideosList setApiKey(string $key)
 * @method VideosList setChart($value)
 * @method VideosList setId($value)
 * @method VideosList setMaxHeight($value)
 * @method VideosList setMaxWidth($value)
 * @method VideosList setMaxResults($value)
 * @method VideosList setPageToken($value)
 * @method VideosList setParams(array $params)
 * @method VideosList setPart($part)
 * @method VideosList setProxy(string $proxy) : Base
 * @method VideosList setRegionCode($value)
 * @method VideosList setVideoCategoryId($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas040490@gmail.com>
 */
class VideosList extends Base
{
    const PART_CONTENT_DETAILS = 'contentDetails';
    const PART_SNIPPET = 'snippet';
    const PART_ID = 'id';
    const PART_STATUS = 'status';
    const PART_LOCALIZATIONS = 'localizations';
    const PART_PLAYER = 'player';
    const PART_RECORDING_DETAILS = 'recordingDetails';
    const PART_STATISTICS = 'statistics';
    const PART_TOPIC_DETAILS = 'topicDetails';
    const PART_LIVE_STREAMING_DETAILS = 'liveStreamingDetails';


    /**
     * @var string
     */
    protected $url = 'https://www.googleapis.com/youtube/v3/videos';

    /**
     * Youtube Data API key
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $params = [
        'part' => [self::PART_SNIPPET, self::PART_CONTENT_DETAILS, self::PART_ID, self::PART_STATUS],
        'id' => null,
        'chart' => null,
        'maxResults' => 50,
        'maxHeight' => null,
        'maxWidth' => null,
        'pageToken' => null,
        'regionCode' => null,
        'videoCategoryId' => null,
    ];

    public function getAllowedParts(): array
    {
        return [
            self::PART_CONTENT_DETAILS,
            self::PART_SNIPPET,
            self::PART_ID,
            self::PART_STATUS,
            self::PART_LOCALIZATIONS,
            self::PART_PLAYER,
            self::PART_RECORDING_DETAILS,
            self::PART_STATISTICS,
            self::PART_TOPIC_DETAILS,
            self::PART_LIVE_STREAMING_DETAILS,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIterator($cloned = false)
    {
        return new ListIterator(($cloned ? $this : clone $this), $this->params['pageToken']);
    }
}
