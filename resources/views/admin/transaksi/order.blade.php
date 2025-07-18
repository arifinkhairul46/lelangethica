@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 style="margin-left: 1rem">Transaksi Order</h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#add_order"> Add order </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_order" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Agen</th>
                                @foreach ($list_produk as $item)
                                <th> {{$item->nama_produk}} </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px">
                            @foreach ($order_by_agen as $item )
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td> {{$item->agen}} </td>
                                    <td> {{$item->produk_f}} </td>
                                    <td> {{$item->produk_g}} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal create produk --}}
    <div class="modal fade" id="add_order" tabindex="-1" role="dialog" aria-labelledby="create_produk" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_produk">Tambah produk</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id" class="form-control-label">Nama Agen</label>
                        <select name="user_id" id="user_id" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                            <option value="" disabled selected> -- Pilih Agen --</option>
                                @foreach ($list_user as $item)
                                    <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="produk_id" class="form-control-label">Produk</label>
                        <select name="produk_id" id="produk_id" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                            <option value="" disabled selected> -- Pilih Produk --</option>
                                @foreach ($list_produk as $item)
                                    <option value="{{ $item->id }}" >{{ $item->nama_produk }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="qty_order" class="form-control-label">Quantity Order</label>
                        <input type="number" class="form-control" name="qty_order" id="qty_order">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" onclick="save_order()" >Create</button>
                </div>
            </div>
        </div>
    </div>


     {{-- edit --}}
    <div class="modal fade" id="edit_produk" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit">Edit Produk</h5>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="editForm">
                    @csrf @method('PUT')
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="nama_produk_edit" class="form-control-label">Nama produk</label>
                            <input type="text" class="form-control" name="nama_produk_edit" id="nama_produk_edit" required>
                        </div>

                       <div class="form-group">
                            <label for="qty_stok_edit" class="form-control-label">Stok</label>
                            <input type="number" class="form-control" name="qty_stok_edit" id="qty_stok_edit">
                        </div>

                        <div class="form-group">
                            <label for="status_edit" class="form-control-label">Status</label>
                            <select name="status_edit" id="status_edit" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih status --</option>
                                <option value="1"> Aktif-</option>
                                <option value="0"> Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm" >Update</button>
                    </div>
                </form>
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

        function save_order(){
            let qty = $('#qty_order').val();
            let user_id = $('#user_id').val();
            let produk_id = $('#produk_id').val();

            if(qty == '' || user_id == '' || produk_id == ''){
                alert('Semua field harus diisi');
                return;
            }
            $.ajax({
                url: "{{ route('checkout') }}",
                type: "POST",
                data: {
                    user_id: user_id,
                    id: produk_id,
                    qty: qty,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#add_order').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }

        function zoomImage(file){
            $('#zoom_image').modal('show')
            $('#img_modal').attr('src', file)
        }
    </script>
@endsection
