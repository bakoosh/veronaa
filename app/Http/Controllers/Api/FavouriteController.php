<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Illuminate\Http\Request;


class FavouriteController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->query('user_id');
        $query = Favourite::query();

        $response = $query->where('user_id', '=', $user_id)
            ->join('products', 'favourites.product_id', '=' , 'products.id')
            ->select('products.*')
            ->get();


        return response()->json($response);
    }






    public function store(Request $request) {
        $user_id = $request->query('user_id');

        $response = Favourite::updateOrCreate([
            'user_id' => $user_id,
            'product_id' => $request->product_id
        ]);

        return response()->json($response);
    }
}
