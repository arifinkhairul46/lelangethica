@extends('layouts.app')

@section('content')
    @include('top-nav')

    <div class="banner">
        <img src="{{asset('assets/images/banner_ethica.jpg')}}" alt="banner-ethica" width="100%" >
    </div>

    <div class="container">
        <div class="d-grid-card">
            @foreach ($produkList as $item )
                @if($item->datetime_released <= date('Y-m-d H:i:s') && $item->datetime_end >= date('Y-m-d H:i:s') && $item->stok > 0)
                <div class="card shadow text-white bg-dark mb-1">
                    <img src="{{ asset('storage/'.$item->image_produk) }}" class="card-img-top" alt="{{$item->image}}" style="max-height: 240px">
                    <div class="card-body pt-1">
                        <div class="d-flex" style="justify-content: space-between">
                            <h5 class="card-title my-1" style="color: #BCAA97">{{$item->nama_produk}}</h5>
                            <span class="mt-1 p-1 px-2 tri-d bg-success"> <b> Open </b> </span>
                            <span class="bg-danger text-white px-2 pt-1 mt-2" style="font-weight: bold; border-radius: 1rem;" id="batas_lelang_{{$item->id}}" data-countdown = "{{ date('Y-m-d H:i:s', strtotime($item->datetime_end))}}" >{{$item->datetime_end}} </span>
                        </div>
                        <p style="font-size: 12px;">Quantity Stok : <input class="bg-dark" style="border: none" id="stok_avail_{{$item->id}}" value="{{$item->stok}}" disabled> </p>
                        <div class="text-center mt-3">
                            @if (Auth::check())
                                @foreach ($item->takeOptions as $option )
                                    <button type="button" class="btn btn-sm btn-cream" id="{{$option->button->label}}_{{$item->id}}" onclick="{{$option->button->label}}('{{$item->id}}', '{{$item->stok}}')" > {{$option->button->name}} </button>
                                @endforeach
                            @else
                                @foreach ($item->takeOptions as $option )
                                    <a href="{{route('login')}}" style="text-decoration: none"> <button type="button" class="btn btn-sm btn-cream"> {{$option->button->name}} </button> </a>
                                @endforeach
                            @endif
                            <div class="d-flex justify-content-center">
                                <input type="phone" style="display:none; width: 30%" name="radios_{{$item->id}}" id="input_qty_{{$item->id}}" class="form-control form-control-sm text-center mx-2 mt-2">
                                <button type="button" class="btn btn-sm btn-cream mt-2" id="btn_order_custom_{{$item->id}}" style="display: none" onclick="order_custom('{{$item->id}}')" > Order </button>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($item->datetime_released >= date('Y-m-d H:i:s') && $item->datetime_end >= date('Y-m-d H:i:s'))
                    <div class="card shadow text-white bg-dark mb-1">
                        <img src="{{ asset('storage/'.$item->image_produk) }}" class="card-img-top" alt="{{$item->image}}" style="max-height: 240px; filter: opacity(0.3);">
                        <div class="card-body pt-1">
                            <div class="d-flex" style="justify-content: space-between">
                                <h5 class="card-title my-1" style="color: #BCAA97">{{$item->nama_produk}}</h5>
                                <span class="mt-1 p-1 px-2 tri-d bg-warning"> <b> Upcoming </b> </span>
                            </div>
                            <p style="font-size: 12px;">Quantity Stok :  {{$item->stok}} </p>
                            <div class="text-center mt-3">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    @foreach ($item->takeOptions as $option )
                                        <input type="radio" class="btn-check" name="btnradio_{{$item->id}}" id="{{$option->button->label}}_{{$item->id}}" autocomplete="off" disabled>
                                        <label class="btn btn-sm btn-outline-warning" for="{{$option->button->label}}_{{$item->id}}"> {{$option->button->name}} </label>
                                    @endforeach

                                    {{-- <input type="radio" class="btn-check" name="btnradio_{{$item->id}}" id="take_20_{{$item->id}}" autocomplete="off" disabled>
                                    <label class="btn btn-sm btn-outline-warning" for="take_20_{{$item->id}}">Take 20</label>

                                    <input type="radio" class="btn-check" name="btnradio_{{$item->id}}" id="custom_{{$item->id}}" autocomplete="off" disabled>
                                    <label class="btn btn-sm btn-outline-warning" for="custom_{{$item->id}}">Custom</label> --}}

                                </div>
                            </div>
                        </div>
                    </div>

                @else

                    <div class="card shadow text-white bg-dark mb-1">
                        <img src="{{ asset('storage/'.$item->image_produk) }}" class="card-img-top" alt="{{$item->image}}" style="max-height: 240px; filter: opacity(0.3);">
                        <div class="card-body pt-1">
                            <div class="d-flex" style="justify-content: space-between">
                                <h5 class="card-title my-1" style="color: #BCAA97">{{$item->nama_produk}}</h5>
                                <span class="mt-1 p-1 px-2 tri-d bg-danger"> <b> Closed </b> </span>
                            </div>
                            <p style="font-size: 12px;">Quantity Stok : {{$item->stok}} </p>
                            <div class="text-center mt-3">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    @foreach ($item->takeOptions as $option )
                                        <input type="radio" class="btn-check" name="btnradio_{{$item->id}}" id="{{$option->button->label}}_{{$item->id}}" autocomplete="off" disabled>
                                        <label class="btn btn-sm btn-outline-warning" for="{{$option->button->label}}_{{$item->id}}"> {{$option->button->name}} </label>
                                    @endforeach

                                    {{-- <input type="radio" class="btn-check" name="btnradio_{{$item->id}}" id="take_20_{{$item->id}}" autocomplete="off" disabled>
                                    <label class="btn btn-sm btn-outline-warning" for="take_20_{{$item->id}}">Take 20</label>

                                    <input type="radio" class="btn-check" name="btnradio_{{$item->id}}" id="custom_{{$item->id}}" autocomplete="off" disabled>
                                    <label class="btn btn-sm btn-outline-warning" for="custom_{{$item->id}}">Custom</label> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/jquery.countdown/jquery.countdown.min.js') }}"></script>
    <script>
        $('[data-countdown]').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                 if (event.elapsed) {
                    // Waktu sudah habis
                    location.reload(); // Reload halaman
                } else {
                    // Update tampilan countdown
                    $this.html(event.strftime('%H:%M:%S'));
                }
            });
        });

        function custom(id) {
            $('#input_qty_'+ id).show();
            $('#btn_order_custom_'+id).show();

        }

        function close_info() {
            $('#input_qty_' + id).hide();
            $('#btn_order_custom_'+id).hide();
        }

         function take_20(id) {
            $('#input_qty_' + id).hide();
            $('#btn_order_custom_'+id).hide();

            var qty = 20;
            $.ajax({
                url: "{{route('checkout')}}",
                type: 'POST',
                data: {
                    id: id,
                    qty : qty,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#stok_avail_' + id).val(result.stok_now)
                    alert(result.message)
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 400) {
                        alert('Gagal: ' + xhr.responseJSON.message);
                    } else {
                        alert('Terjadi error: ' + xhr.status);
                    }
                }
            });
        }

        function take_all(id, total_stok) {
            $('#input_qty').hide();
            $('#btn_order_custom_'+id).hide();

            $.ajax({
                url: "{{route('checkout')}}",
                type: 'POST',
                data: {
                    id: id,
                    qty : total_stok,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                     $('#stok_avail_' + id).val(result.stok_now)
                    alert(result.message)
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 400) {
                        alert('Gagal: ' + xhr.responseJSON.message);
                    } else {
                        alert('Terjadi error: ' + xhr.status);
                    }
                }
            });
        }

        function order_custom(id) {
            var qty_order = $('#input_qty_' +id).val();

            $.ajax({
                url: "{{route('checkout')}}",
                type: 'POST',
                data: {
                    id: id,
                    qty : qty_order,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#stok_avail_' + id).val(result.stok_now)
                    alert(result.message)
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 400) {
                        alert('Gagal: ' + xhr.responseJSON.message);
                    } else {
                        alert('Terjadi error: ' + xhr.status);
                    }
                }
            });
        }

        setInterval(() => {
            fetch('/server-time')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('server-time').innerText = data.time;
                });
        }, 1000);


    </script>

@endsection
