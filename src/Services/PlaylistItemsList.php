<?php


namespace Igbas90\YoutubeDataApi\Services;

use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;

/**
 * Class PlaylistItemsList
 *
 * @method PlaylistItemsList setApiKey(string $key)
 * @method PlaylistItemsList setId($value)
 * @method PlaylistItemsList setMaxResults($value)
 * @method PlaylistItemsList setPageToken($value)
 * @method PlaylistItemsList setParams(array $params)
 * @method PlaylistItemsList setPart($part)
 * @method PlaylistItemsList setProxy(string $proxy) : Base
 * @method PlaylistItemsList setPlaylistId($value)
 * @method PlaylistItemsList setVideoId($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas0404@mail.com>
 */
class PlaylistItemsList extends Base
{
    const PART_CONTENT_DETAILS = 'contentDetails';
    const PART_SNIPPET = 'snippet';
    const PART_ID = 'id';
    const PART_STATUS = 'status';

    /**
     * @var string
     */
    protected $url = 'https://www.googleapis.com/youtube/v3/playlistItems';

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
        'playlistId' => null,
        'maxResults' => 50,
        'videoId' => null,
        'pageToken' => null,
    ];

    public function getAllowedParts(): array
    {
        return [
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