<?php

namespace BasicAuthProxy;

class HttpClientResponse
{
    private $requiredData = [];

    public function getRequiredData()
    {
        return $this->requiredData;
    }

    public function add($keyValues)
    {
        foreach ($keyValues as $key => $value) {
            $this->requiredData[$key] = $value;
        }
    }
}