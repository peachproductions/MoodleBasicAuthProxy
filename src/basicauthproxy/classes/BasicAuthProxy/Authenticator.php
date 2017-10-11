<?php

namespace BasicAuthProxy;

class Authenticator
{
    private $host;
    /** @var  HttpClient */
    private $httpClient;

    public function __construct($env = null)
    {
        if (!isset($env->config->host)) {
            throw new \Exception('Missing host parameter in Plugin Settings');
        }
        $this->host = $env->config->host;
    }

    public function setHttpClient(HttpClient $client)
    {
        $this->httpClient = $client;
    }

    public function requestAuthentication($username, $password)
    {
        return $this->httpClient->sendAuthRequest($this->host, $username, $password);
    }
}
