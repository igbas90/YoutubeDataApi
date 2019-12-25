<?php

namespace Igbas90\YoutubeDataApi\Exception;

class YoutubeDataApiHttpException extends \Exception
{
    public function __construct($message, $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
