<?php

namespace App\Http\Controllers;

use App\Models\ImageProduk;
use App\Models\OrderLelang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index(){
        $list_produk = Produk::where('status', 1)->get();

        $produkList = Produk::with('takeOptions.button')
        ->where('stok', '>', '0')
        ->where('status', 1)
        ->get();
        // dd($produkList);

        return view('index', compact('list_produk', 'produkList'));
    }

    public function detail(Request $request, $id){
        $produk_by_id = Produk::find($id);
        $image_produk = ImageProduk::where('produk_id', $produk_by_id->id)->get();

        return view('detail', compact('produk_by_id', 'image_produk'));
    }

    public function order_po(Request $request) {
        // $user_id = Auth::user()->id;
        $user_id = $request->user_id;
        $no_order = 'LPO-FGE-'. date('YmdHis') . '-'. $user_id;
        $produk_id = $request->id;
        $qty_order = $request->qty;

        DB::beginTransaction();

        try {
            // update_stok
            $barang = Produk::where('id', $produk_id)->lockForUpdate()->first();

            if ($barang->stok < $qty_order) {
                DB::rollBack();
                return response()->json(['message' => 'Stok tidak cukup'], 400);
            } else if ($qty_order == 0) {
                DB::rollBack();
                return response()->json(['message' => 'Quantity tidak boleh 0'], 400);
            }

            $sisa_stok = $barang->stok - $qty_order;

            $update_stok = Produk::where('id', $produk_id)->update([
                'stok' => $sisa_stok
            ]);

            // create order
            $add_order = OrderLelang::create([
                'user_id' => $user_id,
                'no_order' => $no_order,
                'produk_id' => $produk_id,
                'qty' => $qty_order,
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil checkout',
                'stok_now' => $sisa_stok
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal checkout'], 500);
        }

    }

    public function order_history(){
        $user_id = Auth::user()->id;

        $get_order_user = OrderLelang::select('t_order_lelang.*', 'p.nama_produk', 'p.image_produk')
                        ->leftJoin('m_produk as p', 'p.id', 't_order_lelang.produk_id')
                        ->where('user_id', $user_id)
                        ->get();

        return view('order', compact('get_order_user'));
    }

    public function dashboard($id) {
        $produk = Produk::find($id);

        $order_per_produk_by_agen = OrderLelang::select('u.name as agen',
                            DB::raw("SUM(CASE WHEN p.id = $id THEN t_order_lelang.qty ELSE 0 END) as total_order")
                            )
                            ->leftJoin('users as u', 'u.id', 't_order_lelang.user_id')
                            ->leftJoin('m_produk as p', 'p.id', 't_order_lelang.produk_id')
                            ->having('total_order', '>', 0)
                            ->groupBy('u.id')
                            ->orderBy('u.id')
                            ->get();
        return view('dashboard', compact('produk', 'order_per_produk_by_agen'));
    }

    public function getOrderPerProduk($produk_id)
    {
        $orders = OrderLelang::select('u.name as agen',
                        DB::raw('SUM(t_order_lelang.qty) as total_order'))
                    ->join('users as u', 'u.id', 't_order_lelang.user_id')
                    ->where('produk_id', $produk_id)
                    ->groupBy('u.id', 'u.name')
                    ->havingRaw('SUM(t_order_lelang.qty) > 0')
                    ->orderBy('u.name')
                    ->get();

        return response()->json($orders);
    }
}
