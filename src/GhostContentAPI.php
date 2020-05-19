<?php
/**
 * User: Sergio
 * Date: 2/25/2020
 *
 */

namespace GhostAPI;

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
        $this->authors = new ResourceContent($config, 'authors');
        $this->posts = new ResourceContent($config, 'posts');
        $this->pages = new ResourceContent($config, 'pages');
        $this->tags = new ResourceContent($config, 'tags');
        $this->settings = new ResourceContent($config, 'settings');
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
