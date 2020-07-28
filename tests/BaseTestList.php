<?php


namespace Igbas90\YoutubeDataApi\Tests;


use Igbas90\YoutubeDataApi\Classes\ArrayFormatter;
use Igbas90\YoutubeDataApi\Classes\ListIterator;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiBadResponseException;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiBadRequestException;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiUndefinedMethodException;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiUndefinedPropertyException;
use Igbas90\YoutubeDataApi\Services\Base;
use Igbas90\YoutubeDataApi\Services\ChannelsList;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

abstract class BaseTestList extends TestCase
{
    /** @var $apiClient Base */
    public $apiClient;
    public $apiKey;
    public $proxy;

    abstract public function getLoadParams(): array;

    abstract public function getDefaultParams(): array;

    abstract public function getFailedParams(): array;



    public function testDefaultParams()
    {
        $this->assertInstanceOf(\Igbas90\YoutubeDataApi\Services\Base::class,
            $this->apiClient->setParams($this->getDefaultParams())
        );

        return $this->apiClient;
    }

    /**
     * @depends testDefaultParams
     * @param $apiClient Base
     * @return Base
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function testSetParams($apiClient)
    {
        //TODO: need refactor
        $this->assertInstanceOf(\Igbas90\YoutubeDataApi\Services\Base::class,
            $apiClient->setApiKey($this->apiKey)
                ->setProxy($this->proxy)
                ->resetProxy()
                ->setPart($apiClient->getAllowedParts())
                ->setParams($this->getLoadParams())
        );

        $params = $apiClient->getParams();
        $prepareParams = $apiClient->getPrepareParams();
        foreach ($this->getLoadParams() as $paramName => $value) {
            $this->assertSame($value, ($params[$paramName] ?? null));
        }

        $this->assertEquals($prepareParams['query']['key'] ?? null, $this->apiKey);
        $this->assertEquals($prepareParams['query']['part'] ?? null, implode(",", $apiClient->getAllowedParts()));

        return $apiClient;
    }


    /**
     * @depends testSetParams
     * @param $apiClient ChannelsList
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function testRequest($apiClient)
    {
        $this->assertInstanceOf(ResponseInterface::class, $apiClient->request());
        return $apiClient;
    }

    /**
     * @depends testRequest
     * @param $apiClient ChannelsList
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function testUseProxy($apiClient)
    {
        $this->assertInstanceOf(Base::class, $apiClient->setProxy($this->proxy));
        $this->assertEquals($apiClient->getPrepareParams()['proxy'], $this->proxy);
        $this->assertInstanceOf(ResponseInterface::class, $apiClient->request());
        $this->assertEmpty($apiClient->resetProxy()->getProxy());
        return $apiClient;
    }

    /**
     * @depends testUseProxy
     * @param $apiClient ChannelsList
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function testIterator($apiClient)
    {
        $this->assertInstanceOf(ListIterator::class, $apiClient->getIterator());
        return $apiClient;
    }

    /**
     * @depends testIterator
     * @param $apiClient ChannelsList
     * @throws \Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException
     */
    public function testUseResponseFormatter($apiClient)
    {
        $this->assertInstanceOf(Base::class, $apiClient->setResponseFormatter(new ArrayFormatter()));
        $this->assertIsArray($result = $apiClient->request());
    }

    public function testDocMagick()
    {
        $params = $this->getDefaultParams();
        unset($params['part']);
        $doc = (new \ReflectionClass($this->apiClient))->getDocComment();

        $this->assertIsString($doc, "Dock block is missing");

        foreach ($params as $paramName => $value) {
            $methodName = "set" . (ucfirst($paramName));
            $reg = "/@method +\w* *" . $methodName . "\(/u";
            $this->assertTrue((preg_match($reg, $doc) == 1), "magic method " . $methodName . "() is missing in doc block");
        }
    }

    public function testExceptionsUndefinedMethod()
    {
        $this->expectException(YoutubeDataApiUndefinedMethodException::class);
        $this->apiClient->sert();
    }

    public function testExceptionsUndefinedProperty()
    {
        $this->expectException(YoutubeDataApiUndefinedPropertyException::class);
        $this->apiClient->setParams(['paramFail' => 123]);
    }

    public function testExceptionsInvalidParams()
    {
        $this->expectException(YoutubeDataApiInvalidParamsException::class);
        $this->apiClient->setPart([['failPart']]);
    }

    public function testInvalidProxyTest()
    {
        $this->apiClient->setParams($this->getDefaultParams())->setParams($this->getLoadParams())->setApiKey($this->apiKey);
        $this->expectException(YoutubeDataApiBadRequestException::class);
        $this->apiClient->setProxy("http://a0c51d0a:dd5ce0c1a1@5.8.48.39:32138")->request();
    }

    public function testInvalidParamsException()
    {
        $this->apiClient->setApiKey($this->apiKey)->resetProxy();
        $this->expectException(YoutubeDataApiBadResponseException::class);
        $this->apiClient->setParams($this->getFailedParams())->request();
    }

}
