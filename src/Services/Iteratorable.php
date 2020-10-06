<?php


namespace Igbas90\YoutubeDataApi\Services;


interface Iteratorable
{
    /**
     * @param bool $cloned
     * @return \Iterator
     */
    public function getIterator($cloned = false);
}
