<?php
/**
 * User: Sergio
 * Date: 2/25/2020
 */

namespace Srg\GhostApi;

class ResourceContent extends Resource
{
    /**
     * Resource constructor.
     *
     * @param array $config [url, key, version]
     * @param string $resource posts|authors|tags|pages|settings
     * @throws \Exception
     */
    public function __construct(array $config, $resource)
    {
        parent::__construct($config, 'content', $resource);
    }

    protected function addKeyParam(array $queryParams)
    {
        return array_merge(['key' => $this->config['key']], $queryParams);
    }

    /**
     * @param array $queryParams
     * @return mixed
     */
    public function browse($queryParams = [])
    {
        return $this->request($this->addKeyParam($queryParams));
    }

    /**
     * Returns a resource object
     *
     * @param $identifier
     * @param array $queryParams
     * @return mixed
     * @throws \Exception
     */
    public function read($identifier, $queryParams = [])
    {
        $urlParam = '';

        if (isset($identifier['id'])) {
            $urlParam = $identifier['id'];

        } else if (isset($identifier['slug'])) {
            $urlParam = 'slug/' . $identifier['slug'];

        } else {
            throw new \Exception('id or slug is required');
        }

        return $this->request($this->addKeyParam($queryParams), 'GET', $urlParam);
    }


}

