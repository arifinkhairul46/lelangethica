@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 style="margin-left: 1rem">List Option Button </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-cream btn-sm"  data-bs-toggle="modal" data-bs-target="#add_option_btn"> Add Option Button </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_option_btn" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Button</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($option_button) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">No data available</td>
                                </tr>
                            @endif
                           @foreach ($option_button as $item )
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td> {{$item->nama_produk}} </td>
                                    <td> {{$item->btn_name}} </td>
                                    <td> {{$item->created_at}} </td>
                                    <td class="d-flex">
                                        <button class="btn btn-sm btn-warning mx-2" title="Edit" data-bs-toggle="modal" data-bs-target="#edit_option_btn" onclick="editOptionBtn({{$item->id}})">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <form action="{{route('delete-option_btn', $item->id)}}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
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
    <div class="modal fade" id="add_option_btn" tabindex="-1" role="dialog" aria-labelledby="create_btn" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_btn">Tambah Opsi Button</h5>
                </div>
                <form action="{{route('create.option_btn')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="produk_id" class="form-control-label">Produk</label>
                            <select name="produk_id" id="produk_id" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Produk --</option>
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->id }}" >{{ $item->nama_produk }}</option>
                                    @endforeach
                            </select>
                        </div>

                         <div class="form-group">
                            <label for="take_btn_id" class="form-control-label">Take Button</label>
                            <select name="take_btn_id" id="take_btn_id" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Take Button --</option>
                                    @foreach ($take_btn as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                            </select>
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
    <div class="modal fade" id="edit_option_btn" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit">Edit Take Button</h5>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="editForm">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="produk_id_edit" class="form-control-label">Produk</label>
                            <select name="produk_id_edit" id="produk_id_edit" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Produk --</option>
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->id }}" >{{ $item->nama_produk }}</option>
                                    @endforeach
                            </select>
                        </div>

                         <div class="form-group">
                            <label for="take_btn_id_edit" class="form-control-label">Take Button</label>
                            <select name="take_btn_id_edit" id="take_btn_id_edit" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Take Button --</option>
                                    @foreach ($take_btn as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
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
        function editOptionBtn(id) {
           var url = "{{ route('update-option_btn', '') }}" + "/" + id;
            fetch('/master/option_btn/' + id)
                .then(response => response.json())
                .then(data => {
                    $("#produk_id_edit").val(data.produk_id)
                    $("#take_btn_id_edit").val(data.take_btn_id)
                    $("#editForm").attr('action', url)
                    $("input[name='_method']").val('PUT')
            });
        }
    </script>
@endsection