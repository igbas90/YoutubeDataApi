<?php

namespace Igbas90\YoutubeDataApi\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class YoutubeDataApiBadResponseException extends YoutubeDataApiHttpException
{
    /**
     * @var RequestInterface
     */
    public $request;

    /** @var ResponseInterface|null */
    public $response;

    public function __construct(
        $message,
        RequestInterface $request,
        ResponseInterface $response = null,
        $code = 0,
        \Exception $previous = null)
    {
        $this->request = $request;
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
