<?php


namespace Igbas90\YoutubeDataApi\Tests\traits;


use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\CommentsThreadList;
use Igbas90\YoutubeDataApi\Services\Iteratorable;

trait Iteration
{
    /**
     * @depends testRequest
     * @param $apiClient Base
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function testHasIterator($apiClient)
    {
        $this->assertInstanceOf(ListIterator::class, $apiClient->getIterator());
        return $apiClient;
    }

    /**
     * @depends testHasIterator
     * @param $apiClient Base|Iteratorable
     */
    public function testIteration(Iteratorable $apiClient)
    {
        $iterator = $apiClient->getIterator();

        foreach($iterator as $response) {
            if (empty($pageToken)) {
                $pageToken = $iterator->getNextPageToken();
                $body = json_decode($response->getBody(), true);
                $data = array_map(function($item) {
                    return $item['id'];
                }, $body['items']);

                continue;
            } else {
                $this->assertFalse($pageToken == $iterator->getNextPageToken());

                $body = json_decode($response->getBody(), true);
                $dataPart2 = array_map(function($item) {
                    return $item['id'];
                }, $body['items']);

                $this->assertNotEmpty(array_diff($data, $dataPart2));
                break;
            }
        }

        $this->assertFalse($pageToken == ListIterator::FAIL_PAGE_TOKEN, 'very few comments for the test');
    }
}
