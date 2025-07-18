<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Brands;
use App\Models\ImageProduk;
use App\Models\OrderLelang;
use App\Models\Produk;
use App\Models\Role;
use App\Models\Sarimbit;
use App\Models\TakeButton;
use App\Models\TakeOptionProduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index(){
        $list_user = User::select('users.*', 'r.role')
        ->leftJoin('roles as r', 'r.id', 'users.role_id')->get();
        $list_role = Role::all();

        return view('admin.master.user', compact('list_user', 'list_role'));
    }

    public function create_user(Request $request){
        $no_hp = $request->no_hp;
        $nama_lengkap = $request->nama_lengkap;
        $nama_toko = $request->nama_toko;
        $email = $request->email;
        $username = $request->username;
        $id_role = $request->id_role;
        $pass = $request->password;

        $create = User::create([
            'name' => $nama_lengkap,
            'no_hp' => $no_hp,
            'nama_toko' => $nama_toko,
            'email' => $email,
            'username' => $username,
            'password' => Hash::make($pass),
            'role_id' => $id_role,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'berhasil menambah user');
    }

    public function user_by_id(Request $request, $id)
    {
        $user_by_id = User::where('id', $id)->first();

        return response()->json($user_by_id);
    }

    public function update_user(Request $request, $id){
        try {

            $update_materi = User::where('id', $id)->update([
                'name' => $request->nama_lengkap_edit,
                'no_hp' => $request->no_hp_edit,
                'nama_toko' => $request->nama_toko_edit,
                'email' => $request->email_edit,
                'username' => $request->username_edit,
                // 'password' => Hash::make($request->password_edit),
            ]);
            return redirect()->back()->withSuccess('Success update Materi ');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    public function list_produk(){
        $brand = Brands::all();
        $sarimbit = Sarimbit::all();
        $list_produk = Produk::select('m_produk.*', 'b.name as name_brand', 's.name as name_sarimbit')
                                ->leftJoin('m_brands as b', 'b.id', 'm_produk.brand_id')
                                ->leftJoin('m_sarimbit as s', 's.id', 'm_produk.sarimbit_id')
                                // ->where('m_produk.status', 1)
                                ->get();

        return view ('admin.master.produk', compact('list_produk', 'brand', 'sarimbit'));
    }

    public function produk_by_id(Request $request, $id)
    {
        $user_by_id = Produk::where('id', $id)->first();

        return response()->json($user_by_id);
    }


    public function create_produk(Request $request){
        $brand_id = $request->brand_id;
        $sarimbit_id = $request->sarimbit_id;

        $nama_produk = $request->nama_produk;
        $stok = $request->qty_stok;
        $released = $request->released;
        $date_end = $request->date_end;

        $image_url = null;
        $path = 'produk/image_produk';

        if ($request->has('image_produk')) {
            $image      = $request->file('image_produk');
            $image_name = $image->getClientOriginalName();

            // Path tujuan di folder public
            $destinationPath = public_path($path);

            // Pindahkan file
            $image->move($destinationPath, $image_name);

            $image_url = $path . '/' . $image_name;

            // $image_name = $request->file('image_produk')->getClientOriginalName();
            // $image_url = $path . '/' . $image_name;
            // Storage::disk('public')->put($image_url, file_get_contents($request->file('image_produk')->getRealPath()));
        } else {
            return redirect()->back()->with('error', 'Image tidak boleh kosong');
        }

        $create = Produk::create([
            'nama_produk' => $nama_produk,
            'brand_id' => $brand_id,
            'sarimbit_id' => $sarimbit_id,
            'stok' => $stok,
            'stok_awal' => $stok,
            'datetime_released' => $released,
            'datetime_end' => $date_end,
            'image_produk' => $image_url,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'berhasil menambah produk');
    }

    public function update_produk(Request $request, $id){
        try {

            $update_produk = Produk::where('id', $id)->update([
                'nama_produk' => $request->nama_produk_edit,
                'stok' => $request->qty_stok_edit,
                'brand_id' => $request->brand_id_edit,
                'sarimbit_id' => $request->sarimbit_id_edit,
                'datetime_released' => $request->released_edit,
                'datetime_end' => $request->date_end_edit,
                'status' => $request->status_edit
            ]);
            return redirect()->back()->withSuccess('Success update Produk ');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    public function list_image_produk(){
        $produk = Produk::where('status', 1)->get();
        $list_image_produk = Produk::select('ip.*', 'm_produk.nama_produk')
                                ->leftJoin('m_image_produk as ip', 'ip.produk_id', 'm_produk.id')
                                ->where('ip.status', 1)
                                ->get();

        return view ('admin.master.image-produk', compact('list_image_produk', 'produk'));
    }

    public function image_produk_by_id(Request $request, $id)
    {
        $user_by_id = ImageProduk::where('id', $id)->first();

        return response()->json($user_by_id);
    }


    public function create_image_produk(Request $request){

        $produk = $request->produk_id;
        $image = null;
        $image_url = null;
        $path = 'produk/image_produk';

        if ($request->has('image_produk')) {
            $image = $request->file('image_produk')->store($path);
            $image_name = $request->file('image_produk')->getClientOriginalName();
            $image_url = $path . '/' . $image_name;
            Storage::disk('public')->put($image_url, file_get_contents($request->file('image_produk')->getRealPath()));
        } else {
            return redirect()->back()->with('error', 'Image tidak boleh kosong');
        }

        $create = ImageProduk::create([
            'produk_id' => $produk,
            'image_produk' => $image_url,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'berhasil menambah image produk');
    }

    public function update_image_produk(Request $request, $id){
        try {

            $update_produk = Produk::where('id', $id)->update([
                'nama_produk' => $request->nama_produk_edit,
                'stok' => $request->qty_stok_edit,
                'brand_id' => $request->brand_id_edit,
                'sarimbit_id' => $request->sarimbit_id_edit,
                'harga' => $request->harga_edit,
                'hpp' => $request->hpp_edit,
                'diskon' => $request->diskon_edit,
            ]);
            return redirect()->back()->withSuccess('Success update Produk ');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    public function laporan_order() {
        $get_order = OrderLelang::select('t_order_lelang.*', 'u.name as nama_customer', 'p.nama_produk')
                    ->leftJoin('m_produk as p', 'p.id', 't_order_lelang.produk_id')
                    ->leftJoin('users as u', 'u.id', 't_order_lelang.user_id')
                    ->get();

        return view('admin.laporan.index', compact('get_order'));
    }

    public function export_order()
    {
        $now = date('d-m-y');
        $file_name = 'order-po-'.$now.'.xlsx';
        return Excel::download(new OrderExport(), $file_name);
    }

    public function take_option_produk()
    {
        $option_button = TakeButton::select('mtop.id', 'mp.nama_produk', 'm_take_button.name as btn_name', 'mtop.created_at')
                        ->leftJoin('m_take_option_produk as mtop', 'mtop.take_btn_id', 'm_take_button.id')
                        ->leftJoin('m_produk as mp', 'mtop.produk_id', 'mp.id')
                        ->get();

        $produk = Produk::where('status', 1)->where('stok', '>', 0)->get();

        $take_btn = TakeButton::all();


        return view ('admin.master.option-btn', compact('option_button', 'produk', 'take_btn'));

    }

    public function create_option_btn(Request $request){

        $produk = $request->produk_id;
        $take_btn = $request->take_btn_id;

        $create = TakeOptionProduk::create([
            'produk_id' => $produk,
            'take_btn_id' => $take_btn,
        ]);

        return redirect()->back()->with('success', 'berhasil menambah opsi button');
    }

    public function option_btn_by_id(Request $request, $id)
    {
        $option_btn_by_id = TakeOptionProduk::where('id', $id)->first();

        return response()->json($option_btn_by_id);
    }

    public function update_option_btn(Request $request, $id){
        try {

            $update_option = TakeOptionProduk::where('id', $id)->update([
                'produk_id' => $request->produk_id_edit,
                'take_btn_id' => $request->take_btn_id_edit,
            ]);
            return redirect()->back()->withSuccess('Success update Opsi Button ');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    public function delete_option_btn($id) {
        try {
            $delete = TakeOptionProduk::where('id', $id)->delete();
            return redirect()->back()->withSuccess('Berhasil menghapus opsi button');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function list_order(){
        $list_produk = Produk::where('status', 1 )->get();
        $list_user = User::where('role_id', 2)->get();

        $order_by_agen = OrderLelang::select('u.name as agen',
                            DB::raw('SUM(CASE WHEN p.id = 1 THEN t_order_lelang.qty ELSE 0 END) AS produk_a'),
                            DB::raw('SUM(CASE WHEN p.id = 2 THEN t_order_lelang.qty ELSE 0 END) AS produk_b'),
                            DB::raw('SUM(CASE WHEN p.id = 3 THEN t_order_lelang.qty ELSE 0 END) AS produk_c'),
                            DB::raw('SUM(CASE WHEN p.id = 4 THEN t_order_lelang.qty ELSE 0 END) AS produk_d'),
                            DB::raw('SUM(CASE WHEN p.id = 5 THEN t_order_lelang.qty ELSE 0 END) AS produk_e'),
                            DB::raw('SUM(CASE WHEN p.id = 6 THEN t_order_lelang.qty ELSE 0 END) AS produk_f'),
                            DB::raw('SUM(CASE WHEN p.id = 7 THEN t_order_lelang.qty ELSE 0 END) AS produk_g'),
                            DB::raw('SUM(CASE WHEN p.id = 8 THEN t_order_lelang.qty ELSE 0 END) AS produk_h'),
                            DB::raw('SUM(CASE WHEN p.id = 9 THEN t_order_lelang.qty ELSE 0 END) AS produk_i'),
                            DB::raw('SUM(CASE WHEN p.id = 10 THEN t_order_lelang.qty ELSE 0 END) AS produk_j')
                            )
                            ->leftJoin('users as u', 'u.id', 't_order_lelang.user_id')
                            ->leftJoin('m_produk as p', 'p.id', 't_order_lelang.produk_id')
                            ->groupBy('u.id')
                            ->orderBy('u.id')
                            ->get();

        return view('admin.transaksi.order', compact('list_produk', 'list_user', 'order_by_agen'));
    }

}
