@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 style="margin-left: 1rem">List User </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#add_user"> Add User </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_user" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nama Toko </th>
                                <th>No Hp</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($list_user as $item )
                           <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> {{$item->name}} </td>
                                <td> {{$item->nama_toko}} </td>
                                <td> {{$item->no_hp}} </td>
                                <td> {{$item->email}} </td>
                                <td> {{$item->username}} </td>
                                <td> {{$item->role}} </td>
                                <td class="d-flex">
                                    <button class="btn btn-sm btn-warning" title="Edit" onclick="edit_user('{{$item->id}}')" data-bs-toggle="modal" data-bs-target="#edit_user">
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

    {{-- modal create user --}}
    <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="create_user" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_user">Tambah user</h5>
                </div>
                <form action="{{route('create.user')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_lengkap" class="form-control-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_toko" class="form-control-label">Nama Toko</label>
                            <input type="text" class="form-control" name="nama_toko" id="nama_toko" required>
                        </div>

                        <div class="form-group">
                            <label for="no_hp" class="form-control-label">No Hp</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-control-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>

                        <div class="form-group">
                            <label for="id_role" class="form-control-label">Role</label>
                            <select name="id_role" id="id_role" class="select2 form-control form-control-sm" aria-label=".form-select-sm" required>
                                <option value="" disabled selected> -- Pilih Role --</option>
                                    @foreach ($list_role as $item)
                                        <option value="{{ $item->id }}" >{{ $item->role }}</option>
                                    @endforeach
                            </select>
                        </div>
                
                         <div class="form-group">
                            <label for="username" class="form-control-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>

                         <div class="form-group">
                            <label for="password" class="form-control-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" id="id_harga_user">
                        <button type="submit" class="btn btn-success btn-sm" onclick="#" >Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     {{-- edit --}}
    <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit">Edit User</h5>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="editForm">
                    @csrf @method('PUT')
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="nama_lengkap_edit" class="form-control-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap_edit" id="nama_lengkap_edit" required>
                        </div>
                      
                        <div class="form-group">
                            <label for="nama_toko_edit" class="form-control-label">Nama Toko</label>
                            <input type="text" class="form-control" name="nama_toko_edit" id="nama_toko_edit" required>
                        </div>

                        <div class="form-group">
                            <label for="no_hp_edit" class="form-control-label">No Hp</label>
                            <input type="text" class="form-control" name="no_hp_edit" id="no_hp_edit" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email_edit" class="form-control-label">Email</label>
                            <input type="email" class="form-control" name="email_edit" id="email_edit">
                        </div>

                         <div class="form-group">
                            <label for="username_edit" class="form-control-label">Username</label>
                            <input type="text" class="form-control" name="username_edit" id="username_edit" required>
                        </div>

                         {{-- <div class="form-group">
                            <label for="password_edit" class="form-control-label">Password</label>
                            <input type="password" class="form-control" name="password_edit" id="password_edit" required>
                        </div> --}}

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
         function edit_user(id) {
            var url = "{{ route('update-user', '') }}" + "/" + id;
            fetch('/master/user/' + id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    $("#nama_lengkap_edit").val(data.name)
                    $("#nama_toko_edit").val(data.nama_toko)
                    $("#no_hp_edit").val(data.no_hp)
                    $("#email_edit").val(data.email)
                    $("#username_edit").val(data.username)
                    // $("#password_edit").val(data.password)
                    $("#editForm").attr('action', url)
                    $("input[name='_method']").val('PUT')
                })
        }
    </script>
@endsection