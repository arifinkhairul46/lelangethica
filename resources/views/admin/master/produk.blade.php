@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 style="margin-left: 1rem">List Produk </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#add_produk"> Add Produk </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_produk" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Brand </th>
                                <th>Sarimbit</th>
                                <th>Stok</th>
                                <th>Image Produk</th>
                                <th>Date Released</th>
                                <th>Date End</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px">
                           @foreach ($list_produk as $item )
                           <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> {{$item->nama_produk}} </td>
                                <td> {{$item->name_brand}} </td>
                                <td> {{$item->name_sarimbit}} </td>
                                <td> {{$item->stok}} </td>
                                <td><img src="{{asset('storage/'.$item->image_produk)}}" id="img_produk_{{$item->id}}"  onclick="zoomImage('{{asset('storage/'.$item->image_produk)}}')" width="50"></td>
                                <td> {{date('d-m-Y; H:i', strtotime($item->datetime_released)) }} </td>
                                <td> {{date('d-m-Y; H:i', strtotime($item->datetime_end))}} </td>
                                <td class="d-flex">
                                    <button class="btn btn-sm btn-warning" title="Edit" onclick="edit_produk('{{$item->id}}')" data-bs-toggle="modal" data-bs-target="#edit_produk">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal create produk --}}
    <div class="modal fade" id="add_produk" tabindex="-1" role="dialog" aria-labelledby="create_produk" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_produk">Tambah produk</h5>
                </div>
                <form action="{{route('create.produk')}}" enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_produk" class="form-control-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" id="nama_produk">
                        </div>

                        <div class="form-group">
                            <label for="qty_stok" class="form-control-label">Stok</label>
                            <input type="number" class="form-control" name="qty_stok" id="qty_stok">
                        </div>

                        <div class="form-group">
                            <label for="brand_id" class="form-control-label">Brand</label>
                            <select name="brand_id" id="brand_id" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Brand --</option>
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sarimbit_id" class="form-control-label">Sarimbit</label>
                            <select name="sarimbit_id" id="sarimbit_id" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Sarimbit --</option>
                                    @foreach ($sarimbit as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image_produk" class="form-control-label">Image Produk</label>
                            <input type="file" class="form-control" name="image_produk" id="image_produk" required>
                        </div>

                         <div class="form-group">
                            <label for="released" class="form-control-label">Datetime Released</label>
                            <input type="datetime-local" class="form-control" name="released" id="released">
                        </div>

                         <div class="form-group">
                            <label for="date_end" class="form-control-label">Datetime End</label>
                            <input type="datetime-local" class="form-control" name="date_end" id="date_end">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm" onclick="#" >Create</button>
                    </div>
                </form>
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
                            <label for="brand_id_edit" class="form-control-label">Brand</label>
                            <select name="brand_id_edit" id="brand_id_edit" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Brand --</option>
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sarimbit_id_edit" class="form-control-label">Sarimbit</label>
                            <select name="sarimbit_id_edit" id="sarimbit_id_edit" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Sarimbit --</option>
                                    @foreach ($sarimbit as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="released_edit" class="form-control-label">Datetime Released</label>
                            <input type="datetime-local" class="form-control" name="released_edit" id="released_edit">
                        </div>

                         <div class="form-group">
                            <label for="date_end_edit" class="form-control-label">Datetime End</label>
                            <input type="datetime-local" class="form-control" name="date_end_edit" id="date_end_edit">
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

    {{-- modal zoom image --}}
    <div class="modal fade" id="zoom_image" tabindex="-1" role="dialog" aria-labelledby="zoom" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <img id="img_modal" src="#" alt="image-cover" width="100%" >
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