<?php

namespace BasicAuthProxy;

class AuthenticatorFactory
{
    public static function create($env)
    {
        $auth = new Authenticator($env);
        $auth->setHttpClient(new HttpClientGuzzle());
        return $auth;
    }
}