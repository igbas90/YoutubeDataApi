<?php

namespace Igbas90\YoutubeDataApi;

use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\ChannelsList;
use Igbas90\YoutubeDataApi\Services\PlaylistItemsList;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;
use Igbas90\YoutubeDataApi\Services\SubscriptionsList;
use Igbas90\YoutubeDataApi\Services\CommentsThreadList;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiUndefinedPropertyException;
use Igbas90\YoutubeDataApi\Services\VideosList;


/**
 * Class YoutubeDataApi
 * @package Igbas90\YoutubeDataApi
 *
 * @property CommentsThreadList $commentsThreadList
 * @property SubscriptionsList $subscriptionsList
 * @property ChannelsList $channelsList
 * @property PlaylistItemsList $playlistItemsList
 * @property VideosList $videosList
 *
 * @author Alexey Sidorkevich <igbas0404@mail.com>
 */
class YoutubeDataApi
{
    const THREAD_COMMENTS_LIST = 'commentsThreadList';
    const SUBSCRIPTIONS_LIST = 'subscriptionsList';
    const CHANNELS_LIST = 'channelsList';
    const PLAYLIST_ITEMS_LIST = 'playlistItemsList';
    const VIDEOS_LIST = 'videosList';

    /**
     * this proxy will be put to services at the time of the first call
     * @var string
     */
    protected $proxy;

    /**
     * this proxy will be put to services at the time of the first call
     * @var string
     */
    protected $apiKey;

    /**
     * this proxy will be put to services at the time of the first call
     * @var ResponseFormatter
     */
    protected $responseFormatter;


    protected $objects = [];

    public function __construct(array $config = [])
    {
        $this->objects[self::THREAD_COMMENTS_LIST] = CommentsThreadList::class;
        $this->objects[self::SUBSCRIPTIONS_LIST] = SubscriptionsList::class;
        $this->objects[self::CHANNELS_LIST] = ChannelsList::class;
        $this->objects[self::PLAYLIST_ITEMS_LIST] = PlaylistItemsList::class;
        $this->objects[self::VIDEOS_LIST] = VideosList::class;

        foreach ($config as $key => $value) {

        }

        if (!empty($config['proxy'])) {
            $this->setProxy($config['proxy']);
        }

        if (!empty($config['apiKey'])) {
            $this->setApiKey($config['apiKey']);
        }

        if (!empty($config['responseFormatter'])) {
            $this->setResponseFormatter($config['responseFormatter']);
        }
    }

    public function setProxy(string $proxy)
    {
        $this->proxy = $proxy;
    }

    public function clearProxy()
    {
        $this->proxy = null;
        return $this;
    }

    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setResponseFormatter(ResponseFormatter $formatter)
    {
        $this->responseFormatter = $formatter;
    }

    public function __get($propertyName)
    {
        if (empty($this->objects[$propertyName])) {
            throw new YoutubeDataApiUndefinedPropertyException("undefined property name '" . $propertyName . "'");
        }

        $class = $this->objects[$propertyName];

        if (!is_object($class)) {
            $class = $this->initService($class);
            $this->objects[$propertyName] = $class;
        }

        return  $class;
    }

    protected function initService(string $className)
    {
        /** @var Base $service */
        $service = new $className();

        if ($this->proxy) {
            $service->setProxy($this->proxy);
        }

        if ($this->apiKey) {
            $service->setApiKey($this->apiKey);
        }

        if ($this->responseFormatter) {
            $service->setResponseFormatter($this->responseFormatter);
        }

        return $service;
    }
}