<?php

namespace App\Exports;

use App\Models\OrderLelang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = OrderLelang::select('t_order_lelang.no_order', 'u.name as nama_customer', 'p.nama_produk', 't_order_lelang.qty', 't_order_lelang.created_at')
                    ->leftJoin('m_produk as p', 'p.id', 't_order_lelang.produk_id')
                    ->leftJoin('users as u', 'u.id', 't_order_lelang.user_id')
                    ->get();
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'No Order',
            'Nama Customer',
            'Nama Produk',
            'Quantity',
            'Waktu Order',
        ];
    }
}
