<?php

use App\Models\OrderLelang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/auction/sold-count/{produk_id}', function ($produk_id) {
    $sold = OrderLelang::where('produk_id', $produk_id)->sum('qty');
    $stok = Produk::where('id', $produk_id)->value('stok');

    return response()->json([
        'sold' => $sold,
        'stok' => $stok,
        'available' => max(0, $stok - $sold)
    ]);
});
