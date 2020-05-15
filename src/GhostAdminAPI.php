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
        $this->posts = new AdminResource($config, 'posts');
        $this->pages = new AdminResource($config, 'pages');
        $this->tags = new AdminResource($config, 'tags');
        $this->users = new AdminResource($config, 'users');
        $this->images = new AdminResource($config, 'images');
        $this->themes = new AdminResource($config, 'themes');
        $this->site = new AdminResource($config, 'site');
        $this->webhooks = new AdminResource($config, 'webhooks');
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
