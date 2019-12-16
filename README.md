Youtube Data API
=========

## Support APIs
- [channels.list](https://developers.google.com/youtube/v3/docs/channels/list)
- [commentsThread.list](https://developers.google.com/youtube/v3/docs/commentThreads/list)
- [subscriptions.list](https://developers.google.com/youtube/v3/docs/subscriptions/list)
- [videos.list](https://developers.google.com/youtube/v3/docs/videos/list)
- [playlistItems.list](https://developers.google.com/youtube/v3/docs/playlistItems/list)

## Authorization
> <div style="background:rgba(255,0,0,0.3); padding: 10px;"><b>!!! This library not supported OAuth2, only GOOGLE CONSOLE API KEY</b></div>


## Installation

Run in console below command to download package to your project:
```
composer require igbas90/youtube-data-api
```



## Usage

#### Instance

Using a single shell. <b>Services are created when they are accessed</b>
```php
use Igbas90\YoutubeDataApi\YoutubeDataApi;
$dataApiClient = new YoutubeDataApi();
$commentsThreadClient = $dataApi->commentsThreadList;
```
Create only service
```php
use Igbas90\YoutubeDataApi\Services\CommentsThreadList;
$commentsThreadClient = new CommentsThreadList();
```

#### Set params

You can set parameters separately for each service
```php
/** @var $dataApiClient Igbas90\YoutubeDataApi\YoutubeDataApi */
$dataApiClient->commentsThreadList->setApiKey('you google console api key');

$dataApiClient->subscriptionsList->setVideoId('9L9UQANH5oI');
```
Bulk settings
```php
/** @var $dataApiClient Igbas90\YoutubeDataApi\YoutubeDataApi */
$dataApiClient->commentsThreadList->setParams([
    'apiKey' => "you google console api key",
    'params' => [
        'part' => ['part1', 'part2', ...],
        'videoId' => 'string or array',
        ...
    ]
]);
```
Parameters such as <b>apiKey</b>, <b>proxy</b>, <b>responseFormatter</b> can be set to services when creating in the shell
for this, set these parameters in the shell. After creating the services, you can change these
parameters only through the methods of the service itself
```php
use Igbas90\YoutubeDataApi\YoutubeDataApi;

$dataApiClient = new YoutubeDataApi([
    'apiKey' => 'your google console api key',
    'proxy' => 'http://username:password@ip:port',
    'responseFormatter' => new ResponseFormatter()
]);
```

#### Usage proxy

To use a proxy server set it to the service
```php
use Igbas90\YoutubeDataApi\YoutubeDataApi;
$dataApiClient = new YoutubeDataApi();

//set proxy
$dataApiClient->commentsThreadList->setProxy('http://username:password@ip:port');

//reset proxy
$dataApiClient->commentsThreadList->resetProxy();
```
#### Get result


```php
/** @var $client Igbas90\YoutubeDataApi\Services\CommentsThreadList */
$response = $client->request();

```
#### Pagination

For pagination you can manually set <b>pageToken</b>

```php
use Igbas90\YoutubeDataApi\YoutubeDataApi;
$client = (new YoutubeDataApi())->commentsThreadList->setParams([...]);

$response = $client->setPageToken('pageToken')->request();
```

The package has built-in support for paging data. An <b>ITERATOR</b> is used for this.

<b style="color:red;">!!!Attention, the client pageToken will be used as the start for the iterator</b>

```php
/** @var $client \Igbas90\YoutubeDataApi\Services\CommentsThreadList*/ 
$comments = [];
foreach($client->getIterator() as $response) {
    $body = json_decode($response->getBody(), true);
    $comment = array_merge($comments, $body['items']);
}
```

By default, the iterator works with the original service, 
which is not very convenient for using multiple iterators. 
To exclude the influence of the iterator on the service, 
you can set the iterator to work with the service <b>clone</b>.
To do this, call the <b>getIterator()</b> method, with the parameter <b>true</b>.
```php
/** @var $client \Igbas90\YoutubeDataApi\Services\CommentsThreadList*/ 
$iterator1 = $client->getIterator(true);
$iterator2 = $client->setVideoId('videoId')->getIterator(true);
$iterator3 = $client->setParams([
    'videoId' => '9L9UQANH5oI',
    'apiKey' => 'google console api key'
])->getIterator(true);
```


#### Response format
By default, Psr\Http\Message\ResponseInterface is returned
If you need to return a different format, then you can specify
an object that implements the <b>Igbas90\YoutubeDataApi\Classes\ResponseFormatter</b> interface, 
which will be used to convert the returned result.
```php
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;
use Psr\Http\Message\ResponseInterface;

/*
 * Create custom response converter
 */
class BodyJsonDecodeFormatter implements ResponseFormatter
{
    public function format(ResponseInterface $response)
    {
        $content = $response->getBody();
        return json_decode($content, true);
    }
}

/** @var $client Igbas90\YoutubeDataApi\Services\CommentsThreadList */
$client->setResponseFormatter(new BodyJsonDecodeFormatter());

//@var $response array
$response = $client->request();
```

## TEST

forward running the tests you need to set the environment variables in define.php, 
for this just copy define-example.php into define.php
```
cp define-example.php define.php
```
replace define.php values ​​with your values.
```php
define("API_KEY", "google console key");
define("PROXY", "http://username:password@ip:port");
define("CHANNEL_ID", "UCf-b4GSsV5HJysCi6A0Bm6g");
define("PLAYLIST_ID", "UU_x5XG1OV2P6uZZ5FSM9Ttw");
define("VIDEO_ID", "oxQ7wfiS4GY");
```

## Documentations
- [Youtube Data API v3 Doc](https://developers.google.com/youtube/v3/getting-started)






