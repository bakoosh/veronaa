<?php

namespace App\Components;

use http\Client;

class HttpClient
{
    public $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            "base_uri" => "http://176.124.87.206:9494",
            'timeout' => 5.0,
            'verify' => false
        ]);
    }
}
