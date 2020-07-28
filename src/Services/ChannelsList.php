<?php


namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;

/**
 * Class ChannelsList
 * magick methods
 * @method ChannelsList setCategoryId($value)
 * @method ChannelsList setId($value)
 * @method ChannelsList setForUsername($value)
 * @method ChannelsList setHl($value)
 * @method ChannelsList setMaxResults($value)
 * @method ChannelsList setPageToken($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas040490@gmail.com>
 */
class ChannelsList extends Base
{
    const PART_BRANDING_SETTINGS = 'brandingSettings';
    const PART_LOCALIZATIONS = 'localizations';
    const PART_STATISTICS = 'statistics';
    const PART_TOPIC_DETAILS = 'topicDetails';
    const PART_CONTENT_DETAILS = 'contentDetails';
    const PART_SNIPPET = 'snippet';
    const PART_ID = 'id';
    const PART_STATUS = 'status';

    /**
     * @var string
     */
    protected $url = 'https://www.googleapis.com/youtube/v3/channels';

    /**
     * Youtube Data API key
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $params = [
        'part' => [self::PART_SNIPPET, self::PART_CONTENT_DETAILS, self::PART_STATISTICS, self::PART_LOCALIZATIONS],
        'categoryId' => null,
        'forUsername' => null,
        'hl' => null,
        'id' => null,
        'maxResults' => 50,
        'pageToken' => null,
    ];

    public function getAllowedParts(): array
    {
        return [
            self::PART_BRANDING_SETTINGS,
            self::PART_LOCALIZATIONS,
            self::PART_STATISTICS,
            self::PART_TOPIC_DETAILS,
            self::PART_CONTENT_DETAILS,
            self::PART_SNIPPET,
            self::PART_ID,
            self::PART_STATUS
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
