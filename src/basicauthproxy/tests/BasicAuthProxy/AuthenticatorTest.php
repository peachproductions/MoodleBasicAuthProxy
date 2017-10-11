<?php

namespace BasicAuthProxy;

use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    private $env;
    private $auth;

    public function setUp()
    {
        $env = new \stdClass();
        $config = new \stdClass();
        $config->host = 'host url';
        $env->config = $config;
        $this->env = $env;
        $this->auth = new Authenticator($this->env);
    }

    /**
     * @test
     * @expectedException  \Exception
     * @expectedExceptionMessage Missing host parameter in Plugin Settings
     */
    public function instantiateNewInstance_throwsExceptionIfHostDefinitionIsNotFoundInEnv()
    {
        $instance = new Authenticator(new \stdClass());
    }

    /** @test */
    public function instantiateNewInstance_worksWhenHostDefinitionIsFound()
    {
        $this->assertInstanceOf('\BasicAuthProxy\Authenticator', $this->auth);
    }
}
