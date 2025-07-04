@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 style="margin-left: 1rem">Laporan Order PO </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <form action="{{route('export_order')}}" method="GET" ><button class="btn btn-success btn-sm" > Excel </button></form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="get_order" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Order</th>
                                <th>Nama Customer</th>
                                <th>Nama Produk </th>
                                <th>Quantity Order</th>
                                <th>Waktu Order</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px">
                           @foreach ($get_order as $item )
                           <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> {{$item->no_order}} </td>
                                <td> {{$item->nama_customer}} </td>
                                <td> {{$item->nama_produk}} </td>
                                <td> {{$item->qty}} </td>
                                <td> {{ date('d-m-Y H:i:s', strtotime($item->created_at)) }} </td>
                                
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script>
         function edit_produk(id) {
            var url = "{{ route('update-produk', '') }}" + "/" + id;
            fetch('/master/produk/' + id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    $("#nama_produk_edit").val(data.nama_produk)
                    $("#qty_stok_edit").val(data.stok)
                    $("#brand_id_edit").val(data.brand_id)
                    $("#sarimbit_id_edit").val(data.sarimbit_id)
                    $("#harga_edit").val(data.harga)
                    $("#diskon_edit").val(data.diskon)
                    $("#hpp_edit").val(data.hpp)
                    $("#released_edit").val(data.datetime_released)
                    $("#date_end_edit").val(data.datetime_end)
                    $("#status_edit").val(data.status)
                    $("#editForm").attr('action', url)
                    $("input[name='_method']").val('PUT')
                })
        }

        function zoomImage(file){
            $('#zoom_image').modal('show')
            $('#img_modal').attr('src', file)
        }
    </script>
@endsection