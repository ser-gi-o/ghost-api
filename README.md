# PHP API for TryGhost/Ghost
PHP wrapper for Ghost CMS/publishing platform API

## Ghost Content API & Ghost Admin API
PHP wrapper matches the same signatures as the Javascript SDK for GhostContentAPI and GhostAdminAPI

### Setup
Follow Ghost directions for custom integration. https://ghost.org/integrations/custom-integrations/

Add generated keys to .env
```.env
GHOST_CONTENT_KEY=
GHOST_ADMIN_KEY=
GHOST_URL=
GHOST_VERSION=
```

Add to Laravel config/services.php
```php
'ghost' => [
   'content_key' => env('GHOST_CONTENT_KEY'),
   'admin_key'   => env('GHOST_ADMIN_KEY'),
   'url'         => env('GHOST_URL'),
   'version'     => env('GHOST_VERSION'),
],
```
### How to Use

**GhostContentAPI:**
```php

    $config = [
    'url'    => config('services.ghost.url'),
    'key'    => config('services.ghost.content_key'),
    'version'=> config('services.ghost.version'),
    ];

    $api = new GhostContentAPI($config);
    
    $rs = [];  //hold results

    // Browsing posts returns Promise([Post...]);
    // The resolved array will have a meta property
    $rs[] = $api->posts->browse(['limit' => 2, 'include' => 'tags,authors']);
    $rs[] = $api->posts->browse();

    // Reading posts returns Promise(Post);
    $rs[] = $api->posts->read(['id' => 'abcd1234']);
    $rs[] = $api->posts->read(['slug' => 'something'], ['formats' => ['html', 'plaintext']]);

    // Browsing authors returns Promise([Author...])
    // The resolved array will have a meta property
    $rs[] = $api->authors->browse(['page' => 2]);
    $rs[] = $api->authors->browse();

    // Reading authors returns Promise(Author);
    $rs[] = $api->authors->read(['id' => 'abcd1234']);
    // include can be array for any of these
    $rs[] = $api->authors->read(['slug' => 'something'], ['include' => 'count.posts']);

    // Browsing tags returns Promise([Tag...])
    // The resolved array will have a meta property
    $rs[] = $api->tags->browse(['order' => 'slug ASC']);
    $rs[] = $api->tags->browse();

    // Reading tags returns Promise(Tag);
    $rs[] = $api->tags->read(['id' => 'abcd1234']);
    $rs[] = $api->tags->read(['slug' => 'something'], ['include' => 'count.posts']);

    // Browsing pages returns Promise([Page...])
    // The resolved array will have a meta property
    $rs[] = $api->pages->browse(['limit' => 2]);
    $rs[] = $api->pages->browse();

    // Reading pages returns Promise(Page);
    $rs[] = $api->pages->read(['id' => 'abcd1234']);
    $rs[] = $api->pages->read(['slug' => 'something', 'fields' => ['title']]);

    // Browsing settings returns Promise(Settings...)
    // The resolved object has each setting as a key value pair
    $rs[] = $api->settings->browse();

    //output
    dump($rs);
```
**GhostAdminAPI:**
```php
    $config = [
    'url'    => config('services.ghost.url'),
    'key'    => config('services.ghost.admin_key'),
    'version'=> config('services.ghost.version'),
    ];

    $api = new GhostAdminAPI($config);
    
    $rs = []; //hold results
    $rs[] = $api->posts->browse();
    $rs[] = $api->posts->read(['id' => 'abcd1234']);
    $rs[] = $api->posts->delete(['id' => 'abcd1234']);
    
    //todo:
    //$rs[] = $api->posts->add(['title' => 'My first API post']);
    //todo:
    //$rs[] = $api->pages->edit(['id'   => 'abcd1234', 'title' => 'Renamed  my post']);
    
    //output
    dump($rs);
```
All functions follow the same signature as the TryGhost Javascript SDK 
and parameters work the same as the Ghost documentation.

**Ghost API**
* https://ghost.org/docs/api/v3/content/
* Ghost Javascript documentation: https://ghost.org/docs/api/v3/javascript/content/

