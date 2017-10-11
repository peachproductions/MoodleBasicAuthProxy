<?php

namespace BasicAuthProxy;

abstract class HttpClient
{
    protected $headers = ['Accept' => 'application/json'];

    /**
     * Send a request to HTTP endpoint passing username and password for authentication
     *
     * @param string $host HTTP endpoint for resource behind HTTP Basic Auth
     * @param string $username Username
     * @param string $password Password
     * @return HttpClientResponse
     */
    public function sendAuthRequest($host, $username, $password)
    {
        $headers = array_merge($this->headers, ['Authorization' => 'Basic ' . base64_encode("$username:$password")]);
        $client = $this->getClient($host, $headers);
        return $this->sendRequest($client);
    }

    abstract protected function getClient($host, $headers);

    abstract protected function sendRequest($client);
}