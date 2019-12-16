<?php


namespace Igbas90\YoutubeDataApi\Classes;

use Igbas90\YoutubeDataApi\Services\Base;

class ListIterator implements \Iterator
{
    const FAIL_PAGE_TOKEN = -1;

    /**
     * @var Base
     */
    private $resource;

    private $startPageToken;

    private $currentPageToken;

    private $nextPageToken;

    private $response;

    public function __construct(Base $resource, string $startPageToken = null)
    {
        $this->resource = $resource;
        $this->startPageToken = $startPageToken;
        $this->currentPageToken = $this->startPageToken;
    }


    public function setStartPageToken($token)
    {
        $this->startPageToken = is_string($token) ? $token : null;
        return $this;
    }

    public function getCurrentPageToken()
    {
        return $this->currentPageToken;
    }

    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }

    /**
     * @return mixed
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function current()
    {
        return $this->currentPageToken != self::FAIL_PAGE_TOKEN ? $this->request() : null;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->resource->setParams(['pageToken' => $this->startPageToken]);
        $this->currentPageToken = $this->startPageToken;
        $this->response = null;
    }

    /**
     * @return int|string|null
     */
    public function key()
    {
        $key = $this->currentPageToken;
        return $key === null ? 0 : ($key == self::FAIL_PAGE_TOKEN ? null : $key);
    }


    /**
     * @return void
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function next()
    {
        if (($this->nextPageToken === null && empty($this->response))
            || ($this->nextPageToken == $this->currentPageToken && $this->nextPageToken != self::FAIL_PAGE_TOKEN)) {
            $this->request();
        }

        $this->currentPageToken = $this->nextPageToken;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->currentPageToken != self::FAIL_PAGE_TOKEN;
    }

    /**
     * @return mixed
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    protected function request()
    {
        $this->resource->setParams(['pageToken' => $this->currentPageToken]);
        $response = $this->resource->request(false);
        $this->response = clone $response;
        $content = json_decode($this->response->getBody(), true);
        $this->nextPageToken = $content['nextPageToken'] ?? self::FAIL_PAGE_TOKEN;
        return $this->resource->formatResponse($response);
    }
}