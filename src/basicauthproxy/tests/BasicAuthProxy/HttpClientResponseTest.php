<?php

namespace BasicAuthProxy;

use PHPUnit\Framework\TestCase;

class HttpClientResponseTest extends TestCase
{
    /** @test */
    public function getRequiredData_willReturnArray()
    {
        $response = new HttpClientResponse();
        $this->assertTrue(is_array($response->getRequiredData()));
    }

    /** @test */
    public function canAddKeyValuesToData()
    {
        $response = new HttpClientResponse();
        $response->add(['firstname' => 'John']);
        $data = $response->getRequiredData();
        $this->assertTrue(array_key_exists('firstname', $data) && $data['firstname'] = 'John', 'Missing first name John');
    }
}
