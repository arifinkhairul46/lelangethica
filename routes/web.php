<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProdukController::class, 'index'])->name('index');
Route::post('order', [ProdukController::class, 'order_po'])->name('checkout');
Route::get('detail/{id}', [ProdukController::class, 'detail'])->name('detail');
Route::get('orders', [ProdukController::class, 'order_history'])->name('order_history');

Route::group(['middleware' =>['auth', 'admin']], function () {
    Route::prefix('master')->group(function () {
        Route::get('user', [AdminController::class, 'index'])->name('admin.index');
        Route::post('user', [AdminController::class, 'create_user'])->name('create.user');
        Route::get('user/{id}', [AdminController::class, 'user_by_id'])->name('user-by-id');
        Route::put('user/{id}', [AdminController::class, 'update_user'])->name('update-user');

        Route::get('produk', [AdminController::class, 'list_produk'])->name('list_produk');
        Route::get('produk/{id}', [AdminController::class, 'produk_by_id'])->name('produk-by-id');
        Route::post('produk', [AdminController::class, 'create_produk'])->name('create.produk');
        Route::put('produk/{id}', [AdminController::class, 'update_produk'])->name('update-produk');

        Route::get('image-produk', [AdminController::class, 'list_image_produk'])->name('list_image_produk');
        Route::get('image-produk/{id}', [AdminController::class, 'image_produk_by_id'])->name('image-produk-by-id');
        Route::post('image-produk', [AdminController::class, 'create_image_produk'])->name('create.image-produk');
        Route::put('image-produk/{id}', [AdminController::class, 'update_image_produk'])->name('update-image-produk');

        Route::get('option-button', [AdminController::class, 'take_option_produk'])->name('take_option_produk');
        Route::post('option-button', [AdminController::class, 'create_option_btn'])->name('create.option_btn');
        Route::get('option_btn/{id}', [AdminController::class, 'option_btn_by_id'])->name('option_btn-by-id');
        Route::put('option_btn/{id}', [AdminController::class, 'update_option_btn'])->name('update-option_btn');
        Route::delete('option_btn/{id}', [AdminController::class, 'delete_option_btn'])->name('delete-option_btn');





    });

    Route::prefix('laporan')->group(function () {
        Route::get('orders', [AdminController::class, 'laporan_order'])->name('laporan_order');
        Route::get('export-order', [AdminController::class, 'export_order'])->name('export_order');
    });

});

Route::get('/server-time', function () {
    return response()->json([
        'time' => now()->setTimezone('Asia/Jakarta')->format('d-F-Y H:i:s')
    ]);
});

