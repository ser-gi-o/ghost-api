<?php
/**
 * User: Sergio
 * Date: 2/25/2020
 *
 */

namespace Srg\GhostApi;

class GhostAdminAPI
{
    /**
     * GhostAdminAPI constructor.
     *
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        //admin resources
        $this->posts = new ResourceAdmin($config, 'posts');
        $this->pages = new ResourceAdmin($config, 'pages');
        $this->tags = new ResourceAdmin($config, 'tags');
        $this->users = new ResourceAdmin($config, 'users');
        $this->images = new ResourceAdmin($config, 'images');
        $this->themes = new ResourceAdmin($config, 'themes');
        $this->site = new ResourceAdmin($config, 'site');
        $this->webhooks = new ResourceAdmin($config, 'webhooks');
    }

    /**
     * Turns debug on for resources
     *
     * @param bool $on
     */
    public function debug($on = true)
    {
        $resources = get_object_vars($this);

        foreach ($resources as $resource) {
            $resource->debug = $on;
        }
    }
}
