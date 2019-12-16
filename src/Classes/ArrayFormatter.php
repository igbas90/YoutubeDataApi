<?php


namespace Igbas90\YoutubeDataApi\Classes;


use Psr\Http\Message\ResponseInterface;

class ArrayFormatter implements ResponseFormatter
{
    public function format(ResponseInterface $response)
    {
        $content = $response->getBody();
        return json_decode($content, true);
    }
}