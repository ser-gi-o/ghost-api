<?php
/**
 * User: Sergio
 * Date: 2/25/2020
 *
 */

namespace Srg\GhostApi;

class GhostContentAPI
{
    /**
     * GhostContentAPI constructor.
     *
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        //content resources
        $this->authors = new ContentResource($config, 'authors');
        $this->posts = new ContentResource($config, 'posts');
        $this->pages = new ContentResource($config, 'pages');
        $this->tags = new ContentResource($config, 'tags');
        $this->settings = new ContentResource($config, 'settings');
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
