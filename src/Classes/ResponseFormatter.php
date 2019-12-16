<?php


namespace Igbas90\YoutubeDataApi\Classes;


use Psr\Http\Message\ResponseInterface;

interface ResponseFormatter
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function format(ResponseInterface $response);
}