<?php

namespace App\Http\Controllers\Api;

use App\Components\HttpClient;
use App\Http\Controllers\Controller;
use App\Models\PricesByGroup;
use Illuminate\Http\Request;

class PricesByGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = PricesByGroup::all();
        return response()->json([
            'success' => true,
            'prices' => $prices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new HttpClient();
        $products = $client->client->get("https://back.almaray.kz/api/prices");
        $data =json_decode($products->getBody()->getContents());


        foreach ($data->prices as $price) {
            $productArray = json_decode(json_encode($price), true);
            PricesByGroup::updateOrCreate($productArray);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->get('data');
        foreach ($data as $item) {
            PricesByGroup::updateOrCreate(
                [
                    'extra_charge' => $item['typediscount'],
                    'name' => $item['pricegroup']
                ],
                [
                    'price' => (double)$item['price'],
                ]
            );
        }

        response()->json([
            'status' => true,
            'message' => 'Prices updated successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($extra_charge)
    {
        $prices = PricesByGroup::where('extra_charge', $extra_charge)->get();
        return response()->json($prices, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PricesByGroup $pricesByGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PricesByGroup $pricesByGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PricesByGroup $pricesByGroup)
    {
        //
    }
}
