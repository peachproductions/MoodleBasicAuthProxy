<?php

namespace BasicAuthProxy;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use Mockery\MockInterface as mock;

class HttpClientGuzzleTest extends TestCase
{
    public function setUp()
    {

    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @test
     */
    public function whenHttpClientEncountersAProblemWithRemoteApi_willReturnFalse()
    {
        $mock = m::mock('\BasicAuthProxy\HttpClientGuzzle[callApi]')
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('callApi')
            ->andReturnUsing(function() { throw new \Exception(); })
            ->getMock();

        $response = $mock->sendAuthRequest('host', 'username', 'password');

        $this->assertFalse($response);
    }

    /** @test */
    public function whenHttpClientIsSuccessful_willReturnHttpResponseObject()
    {
        $returnValues = [];
        $mock = m::mock('\BasicAuthProxy\HttpClientGuzzle[callApi]')
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('callApi')
            ->andReturn(json_encode($returnValues))
            ->getMock();

        $response = $mock->sendAuthRequest('host', 'username', 'password');

        $this->assertInstanceOf('\BasicAuthProxy\HttpClientResponse', $response);
    }

    /** @test */
    public function whenHttpResponseIncludesRequiredFields_theyAreStoredInTheHttpClientResponse()
    {
        $returnValues = [
            'firstName' => 'John',
            'surname' => 'Smith',
            'email' => 'jsmith@test.com'
        ];

        /** @var mock|\BasicAuthProxy\HttpClientGuzzle $mock */
        $mock = m::mock('\BasicAuthProxy\HttpClientGuzzle[callApi]')
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('callApi')
            ->andReturn(json_encode($returnValues))
            ->getMock();

        /** @var HttpClientResponse $response */
        $response = $mock->sendAuthRequest('host', 'username', 'password');
        $data = $response->getRequiredData();
        $this->assertTrue(array_key_exists('firstname', $data), 'Expected firstname is missing');
        $this->assertTrue(array_key_exists('lastname', $data), 'Expected lastname is missing');
        $this->assertTrue(array_key_exists('email', $data), 'Expected email is missing');
    }
}
