<?php


namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;

/**
 * Class VideosList
 *
 * @method setApiKey(string $key)
 * @method setChart($value)
 * @method setId($value)
 * @method setMaxHeight($value)
 * @method setMaxWidth($value)
 * @method setMaxResults($value)
 * @method setPageToken($value)
 * @method setParams(array $params)
 * @method setPart($part)
 * @method setProxy(string $proxy) : Base
 * @method setRegionCode($value)
 * @method setVideoCategoryId($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas0404@mail.com>
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