<?php
/**
 * User: Sergio
 * Date: 2/25/2020
 */

namespace Srg\GhostApi;

class Resource
{
    /**
     * Configuration parameters for client
     *
     * @var array
     */
    public $config;

    /**
     * Specifies Api service
     *
     * @var string content|admin
     */
    public $service;

    /**
     * Specifies Api resource
     *
     * @var string
     */
    public $resource;

    /**
     * Request header variables
     */
    public $header = [];

    /**
     * Debug flag to output guzzle response
     *
     * @var
     */
    public $debug = false;

    /**
     * Resource constructor.
     *
     * @param array $config [url, key, version]
     * @param string $resource posts|authors|tags|pages|settings
     * @throws \Exception
     */
    public function __construct(array $config, $service, $resource)
    {
        if (! (isset($config['url']) && isset($config['key']) && isset($config['version']))) {
            $msg = 'Ghost Api config requires: [key, url, version]. Provided ' . print_r($config, true);
            throw new \Exception($msg);
        }

        $this->config = $config;
        $this->service = $service;
        $this->resource = $resource;
    }

    /**
     * Add variables to request header
     *
     * @param $header
     */
    protected function setHeader(array $header)
    {
        $this->header = $header;
    }

    /**
     * Returns formatted endpoint uri
     *
     * @param string $urlParams
     * @return string
     */
    private function endpoint($urlParams = '')
    {
        return "/ghost/api/{$this->config['version']}/{$this->service}/{$this->resource}/"
            . ($urlParams ? "$urlParams/" : '');
    }

    /**
     * Api request
     *
     * @param array $queryParams
     * @param string $method
     * @param string $urlParams
     * @return \stdClass
     */
    public function request(array $queryParams, $method = 'GET', $urlParams = '')
    {
        $response = null;
        $path = $this->endpoint($urlParams);

        try {
            //Guzzle client
            $guzzleClient = new \GuzzleHttp\Client([
                'base_uri' => $this->config['url'],
                'headers'  => $this->header,
                'method'   => $method,
            ]);

            //request options
            $options = [
                'query' => $queryParams,
                'debug' => $this->debug,
            ];

            //output debug here. if response is exception it is output in catch
            if ($this->debug)
                dump('Debug request: ' . $method . ' ' . $path, $guzzleClient, $options);

            $requestResponse = $guzzleClient->request($method, $path, $options);

            //response is JSON
            $response = json_decode($requestResponse->getBody()->getContents());

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());

            if ($this->debug)
                dump($e);
        }

        return $response;
    }
}
