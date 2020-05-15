<?php
/**
 * User: Sergio
 * Date: 2/25/2020
 */

namespace Srg\GhostApi;

use Firebase\JWT\JWT;

class AdminResource extends Resource
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
        parent::__construct($config, 'admin', $resource);

        $header = [
            'Authorization' => 'Ghost ' . $this->token($this->config['key']),
        ];

        $this->setHeader($header);
    }

    /**
     * @param array $queryParams
     * @return mixed
     */
    public function browse($queryParams = [])
    {
        return $this->request($queryParams);
    }

    /**
     * Generates JSON Web Token (JWT) from api key
     *
     * @param $key
     * @return string
     */
    private function token($key)
    {
        //Step 1: get id and secret from ghost generated admin key
        list($id, $secret) = explode(':', $key);

        //Step 2: prepare header, payload, and secret to create JSON web token (jwt)
        //header, passing kid in as parameter to JWT::encode which is added to default header
        //payload
        $payload = [
            "aud" => "{$this->config['version']}/admin/", //audience
            "iat" => time(),                              //Issued at Time, Unix timestamp
            "exp" => strtotime('+5 minutes'),        //expiration Unix timestamp
        ];

        //Decode the hexadecimal secret
        $decodedSecret = pack('H*', $secret);

        //Step 3: create token
        $token = JWT::encode($payload, $decodedSecret, 'HS256', $id);

        //debug. return original payload
        //$decoded = JWT::decode($token, $decodedSecret, ['HS256']);

        return $token;
    }

    /**
     * Returns a resource object
     *
     * @param $identifier
     * @param array $queryParams
     * @return mixed
     * @throws \Exception
     */
    public function read($identifier = [], $queryParams = [])
    {
        $urlParam = '';

        if (isset($identifier['id'])) {
            $urlParam = $identifier['id'];

        } else if (isset($identifier['slug'])) {
            $urlParam = 'slug/' . $identifier['slug'];

        } else if ($this->resource == 'site') {
            //site resource is different. not sure why its a read because same request as browse
            //because the response doesn't have meta
            //do nothing

        } else {
            throw new \Exception('id or slug is required');
        }

        return $this->request($queryParams, 'GET', $urlParam);
    }

    /**
     * Updates a resource object
     *
     * @param array $identifier
     * @param $queryParams
     * @return mixed
     * @throws \Exception
     */
    public function edit($queryParams)
    {
        //todo: Create a session, and store the cookie inorder to edit
        if (isset($queryParams['id'])) {
            $urlParam = $queryParams['id'];
            unset($queryParams['id']);

        } else {
            throw new \Exception('id is required');
        }

        //return $this->request($queryParams, 'PUT', $urlParam);
        return new \Exception('To do. Requires session.');
    }

    /**
     * Creates a resource object
     *
     * @param $queryParams
     * @return mixed
     */
    public function add($queryParams)
    {
        //todo: Create a session, and store the cookie inorder to add
        //return $this->request($queryParams,  'POST');
        return new \Exception('To do. Requires session.');
    }

    /**
     * Deletes a resource object
     *
     * @param $identifier
     * @return mixed
     * @throws \Exception
     */
    public function delete($identifier)
    {
        if (isset($identifier['id'])) {
            $urlParam = $identifier['id'];

        } else {
            throw new \Exception('id is required');
        }

        return $this->request([], 'DELETE', $urlParam);
    }


    /**
     * todo: image upload
     *
     * @param $queryParams
     * @return mixed
     */
    public function upload($queryParams)
    {
        //todo:
        //return $this->request($queryParams, 'POST');
        return new \Exception('To do.');
    }



}
