<?php

namespace App\Http\Controllers\Api;

use App\Components\HttpClient;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catalogs = Catalog::all();
        return response()->json([
            'status' => true,
            'catalogs' => $catalogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new HttpClient();
        $catalogs = $client->client->get("https://back.almaray.kz/api/catalogs");
        $data =json_decode($catalogs->getBody()->getContents());


        foreach ($data->catalogs as $catalog) {
            $productArray = json_decode(json_encode($catalog), true);
            Catalog::updateOrCreate($productArray);
        }

        return response()->json('success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->get('data');
        foreach ($data as $item) {
            Catalog::updateOrCreate(
                ['uuid' => $item['uuid']],
                [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                ]
            );
        }

        response()->json([
            'status' => true,
            'message' => 'Catalog updated successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Catalog $catalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalog $catalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Catalog $catalog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalog $catalog)
    {
        //
    }
}
