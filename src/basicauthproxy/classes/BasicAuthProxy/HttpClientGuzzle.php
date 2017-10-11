<?php

namespace BasicAuthProxy;

use BasicAuthProxy\HttpResponse;
use GuzzleHttp\Client;

class HttpClientGuzzle extends HttpClient
{
    /**
     * @param string $host URL for HTTP authentication server
     * @param array $headers Request headers
     * @return Client
     */
    protected function getClient($host, $headers)
    {
        return new Client([
                'base_uri' => $host,
                'headers' => $headers
            ]
        );
    }

    /**
     * @param Client $client GuzzleHttp client
     * @return bool|HttpClientResponse
     */
    protected function sendRequest($client)
    {
        try {
            $responseBody = $this->callApi($client);
            $responseArray = json_decode($responseBody, true);
            $responseObj = new HttpClientResponse();

            $keys = [
                'firstName' => 'firstname',
                'surname' => 'lastname',
                'email' => 'email'
            ];

            $this->storeRequiredFields($keys, $responseArray, $responseObj);
            return $responseObj;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param Client $client Guzzle http client object
     * @return string
     */
    protected function callApi($client)
    {
        $response = $client->request('POST');
        return $response->getBody()->getContents();
    }

    /**
     * @param $keys
     * @param $responseArray
     * @param $responseObj
     */
    protected function storeRequiredFields($keys, $responseArray, $responseObj)
    {
        foreach ($keys as $key => $storedName) {
            if (array_key_exists($key, $responseArray)) {
                $responseObj->add([$storedName => $responseArray[$key]]);
            }
        }
    }
}