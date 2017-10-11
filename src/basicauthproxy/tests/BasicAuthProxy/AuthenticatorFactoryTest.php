<?php

namespace BasicAuthProxy;

use PHPUnit\Framework\TestCase;

class AuthenticatorFactoryTest extends TestCase
{
    /** @test */
    public function canCreateNewInstance()
    {
        $config = new \stdClass();
        $config->host = 'Host URL';
        $env = new \stdClass();
        $env->config = $config;
        $this->assertInstanceOf('\BasicAuthProxy\Authenticator', AuthenticatorFactory::create($env));
    }
}