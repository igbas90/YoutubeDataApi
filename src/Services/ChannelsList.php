<?php


namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;

/**
 * Class ChannelsList
 * magick methods
 * @method setCategoryId($value)
 * @method setId($value)
 * @method setForUsername($value)
 * @method setHl($value)
 * @method setMaxResults($value)
 * @method setPageToken($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas0404@mail.com>
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