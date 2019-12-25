<?php

namespace Igbas90\YoutubeDataApi\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class YoutubeDataApiBadResponseException extends YoutubeDataApiHttpException
{
    public $request;
    public $response;

    public function __construct(
        $message,
        RequestInterface $request,
        ResponseInterface $response = null,
        $code,
        \Exception $previous = null)
    {
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
