<?php

namespace Igbas90\YoutubeDataApi\Services;

/**
 * Class VideoCategoriesList
 *
 * @method VideosList setApiKey(string $key)
 * @method VideosList setId($value)
 * @method VideosList setParams(array $params)
 * @method VideosList setPart($part)
 * @method VideosList setProxy(string $proxy) : Base
 * @method VideosList setRegionCode($value)
 * @method VideosList setHl($value)
 *
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas040490@gmail.com>
 */
class VideoCategoriesList extends Base
{
    const PART_SNIPPET = 'snippet';

    /**
     * @var string
     */
    protected $url = 'https://www.googleapis.com/youtube/v3/videoCategories';

    /**
     * Youtube Data API key
     * @var string
     */
    protected $apiKey;

    /**
     * @var array
     */
    protected $params = [
        'part' => [self::PART_SNIPPET],
        'id' => null,
        'regionCode' => null,
        'hl' => null,
    ];

    public function getAllowedParts(): array
    {
        return [
            self::PART_SNIPPET,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIterator($cloned = false)
    {
        return [];
    }
}
