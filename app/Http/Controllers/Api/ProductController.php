<?php

namespace App\Http\Controllers\Api;

use App\Components\HttpClient;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(Request $request)
    {
        $catalog_id = $request->query('catalog_id');
        $perPage = $request->input('per_page', 100);
        $sort = $request->query('sort');

        $query = Product::query()
            ->join('prices_by_groups', DB::raw('CAST(products.p_group AS bigint)'), '=', 'prices_by_groups.id')
            ->join('catalogs', 'products.catalog_id', '=', 'catalogs.id')
            ->select("prices_by_groups.*" , "products.*", 'catalogs.name as catalog_name');

        if ($catalog_id) {
            $query->where('catalog_id', $catalog_id);
        }

        if ($sort) {
            switch ($sort) {
                case 'popularity':
                    $query->orderBy('products.popularity', 'desc');
                    break;
                case 'new':
                    $query->orderBy('products.created_at', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('prices_by_groups.price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('prices_by_groups.price', 'desc');
                    break;
            }
        }

        $products = $query->paginate($perPage);

        return response()->json($products);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new HttpClient();
        $products = $client->client->get("https://back.almaray.kz/api/products");
        $data = json_decode($products->getBody()->getContents());


        foreach ($data->data as $product) {
            $productArray = json_decode(json_encode($product), true);
            Product::updateOrCreate($productArray);
        }

        return response()->json($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->get('data');

        $catalogs = DB::table('catalogs')
            ->select('uuid', 'id')
            ->get();

        $cat_arr = [];
        foreach ($catalogs as $catalog) {
            $cat_arr[(string)$catalog->uuid] = $catalog->id;
        }

        var_dump($cat_arr);

        foreach ($data as $item) {
            $arr = [
                'name' => $item['title'],
                'vendor' => $item['vendor'],
                'size' => $item['size'],
                'average_weight' => (double)$item['weight'],
                'insert' => $item['insert'],
                'sample' => $item['sample'],
                'catalog_id' => array_key_exists($item['catuid'], $cat_arr) ? $cat_arr[$item['catuid']] : null,
                'new' => $item['new'],
                'p_group' => $item['pricegroup']
            ];

            $image_path = 'img/'.$item['vendor']. '.jpg';
            if (File::exists(public_path($image_path))) {
                $arr['picture_path'] = $image_path;
            }

            Product::updateOrCreate(
                ['uuid' => $item['uuid']],
                $arr
            );
        }
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $query = Product::query();
        $product = $query->select('products.*','products.name as product_name', 'prices_by_groups.*', 'prices_by_groups.name as prices_name')
            ->join('prices_by_groups', DB::raw('CAST(products.p_group AS bigint)'), '=', 'prices_by_groups.id')
            ->where('products.id', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

//    public function getRandomProducts()
//    {
//        try {
//            $query = Product::query();
//            $products = $query->select('products.*', 'prices_by_groups.*')->join('prices_by_groups', DB::raw('CAST(products.p_group AS bigint)'), '=', 'prices_by_groups.id')->inRandomOrder()->limit(4)->get();
//
//            return response()->json($products);
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
