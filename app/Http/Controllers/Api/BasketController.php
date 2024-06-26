<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->query('user_id');
        $query = Basket::query();

        $response = $query->where('user_id', '=', $user_id)
            ->join('products', 'baskets.product_id', '=' , 'products.id')
            ->select('products.*', 'quantity')
            ->orderBy('created_at', 'desc')
            ->get();


        return response()->json($response);
    }

    public function store(Request $request)
    {
        $user_id = $request->query('user_id');


        $basketItem = Basket::where('user_id', $user_id)
            ->where('product_id', $request->product_id)
            ->first();
        if ($basketItem) {
            $basketItem->quantity += $request->quantity;
            $basketItem->save();
        } else {
            $basketItem = Basket::create([
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }


        return response()->json($basketItem);
    }

    public function delete(Request $request)
    {

    }
}
