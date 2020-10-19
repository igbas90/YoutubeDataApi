<?php


namespace Igbas90\YoutubeDataApi\Services;

use GuzzleHttp\Client;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiBadResponseException;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiBadRequestException;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiInvalidParamsException;
use Igbas90\YoutubeDataApi\Classes\ResponseFormatter;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiUndefinedMethodException;
use Igbas90\YoutubeDataApi\Exception\YoutubeDataApiUndefinedPropertyException;

/**
 * Class Base
 * @package Igbas90\YoutubeDataApi\Services
 * @author Alexey Sidorkevich <igbas040490@gmail.com>
 */
abstract class Base
{
    /**
     * Youtube Data API key
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $proxy;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $params = [];

    protected $responseFormatter;

    protected $connectTimeout = null;

    /**
     * ThreadComments constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->setParams($config);
        }
        $this->client = new Client();
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setApiKey(string $key)
    {
        $this->apiKey = $key;
        return $this;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param int $timeout
     * @return $this
     */
    public function setConnectTimeout(int $timeout)
    {
        $this->connectTimeout = $timeout;
        return $this;
    }

    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    public function setResponseFormatter(ResponseFormatter $formatter)
    {
        $this->responseFormatter = $formatter;
        return $this;
    }

    public function resetResponseFormatter()
    {
        $this->responseFormatter = null;
        return $this;
    }

    public function setParams(array $params)
    {
        foreach ($params as $paramName => $paramValues) {
            $methodName = "set" . ucfirst($paramName);
            $this->$methodName($paramValues);
        }
        return $this;
    }

    /**
     * @param $part string|array
     * @return Base
     * @throws YoutubeDataApiInvalidParamsException
     */
    public function setPart($part)
    {
        $values = [];
        if (is_array($part)) {
            foreach ($part as $item) {
                if (! is_string($item)) {
                    throw new YoutubeDataApiInvalidParamsException("part must be array or string");
                }
                $values[] = $item;
            }
        } elseif (is_string($part)) {
            $values[] = $part;
        } else {
            throw new YoutubeDataApiInvalidParamsException("part must be array or string");
        }
        $this->params['part'] = $values;

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getPrepareParams(): array
    {
        $params = array_filter($this->params);

        array_walk($params, function (&$item, $key) {
            if (is_array($item)) {
                $item = implode(",", $item);
            }
        });

        $params['key'] = $this->apiKey;

        $params = array_merge(['query' => $params], ($this->proxy ? ['proxy' => $this->proxy] : []));

        if ($this->connectTimeout) {
            $params['connect_timeout']  =  5;
        }

        return $params;
    }

    abstract public function getAllowedParts(): array;

    /**
     * @param string|null $proxy
     * @return $this
     */
    public function setProxy(string $proxy = null): self
    {
        $this->proxy = $proxy;
        return $this;
    }

    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @return $this
     */
    public function resetProxy()
    {
        $this->proxy = null;
        return $this;
    }

    public function request($format = true)
    {
        if (empty($this->apiKey)) {
            throw new YoutubeDataApiInvalidParamsException('apiKey must be set');
        }

        if (!$this->client) {
            $this->client = new Client();
        }

        try {
            $response = $this->client->request(
                'GET',
                $this->url,
                $this->getPrepareParams());
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            throw new YoutubeDataApiBadResponseException(
                $e->getMessage(),
                $e->getRequest(),
                $e->getResponse(),
                $e->getCode(),
                $e);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new YoutubeDataApiBadRequestException(
                $e->getMessage(),
                $e->getRequest(),
                $e->getResponse(),
                $e->getCode(),
                $e
                );
        }

        return $format ? $this->formatResponse($response) : $response;
    }

    /**
     * @param $response
     * @return mixed
     */
    public function formatResponse($response)
    {
        if (is_object($this->responseFormatter)) {
            return $this->responseFormatter->format($response);
        }
        return $response;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws YoutubeDataApiUndefinedMethodException
     * @throws YoutubeDataApiUndefinedPropertyException
     */
    public function __call($name, $arguments)
    {
        if (!preg_match("/^set[\w]+/", $name)) {
            throw new YoutubeDataApiUndefinedMethodException("unknown method '" . $name . "'");
        }
        $paramName = preg_replace("/^set/", "", $name, 1);
        $paramName = lcfirst($paramName);
        if (!key_exists($paramName, $this->params)) {
            throw new YoutubeDataApiUndefinedPropertyException("unknown property '" . $paramName . "'");
        }

        $this->params[$paramName] = $arguments[0];
        return $this;
    }
}
