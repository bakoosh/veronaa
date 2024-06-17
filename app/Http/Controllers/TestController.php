<?php

namespace App\Http\Controllers;

use App\Components\HttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function test(){
        $http = new HttpClient();

        $response = $http->client->request("GET" , "/");

        $data = $response->getBody()->getContents();

        $posts = json_decode($data);

        return view("layout/app");



    }
}
