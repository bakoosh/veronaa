<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;



class LocationController extends Controller
{
    public function getCityFromCoordinates(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');


        $response = $this->getHttpCity($latitude, $longitude);


        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $data = json_decode($data, true);

            $city = isset($data['address']['city']) ? $data['address']['city'] : 'Unknown';

            return response()->json(['city' => $city], 200);
        } else {
            return response()->json(['error' => 'Failed to fetch city'], $response->getStatusCode());
        }
    }

    private function getHttpCity($latitude, $longitude)
    {
        $http = new Client();
        $response = $http->get("https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$latitude}&lon={$longitude}", [
            "verify" => false
        ]);

        return $response;
    }
}
