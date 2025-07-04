@extends('layouts.app')

@section('content')
    @include('top-nav')

    <div class="banner">
        <img src="{{asset('assets/images/banner_ethica.jpg')}}" alt="banner-ethica" width="100%" >
    </div>

    <div class="container">
        <h4 class="text-white"> Riwayat Orders </h4>

        @foreach ($get_order_user as $item )
            <div class="card card-history mt-3">
                <div class="card-header d-flex" style="justify-content: space-between; font-size: 12px">
                    <span class=""> No Pesanan </span>
                    <span > {{$item->no_order}} </span>
                </div>
                <div class="card-body d-flex">
                    <div class="frame-bayar">
                        <img src="{{asset('storage/'.$item->image_produk)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                    </div>
                    <div class="d-flex mx-2">
                        <div class="" style="width: 150px">
                            <p class="mb-0" style="font-size: 14px;"> {{$item->nama_produk}} </p>
                            <p class="mb-0" style="font-size: 8px">Qty Order: {{$item->qty}} </p>
                            <p class="mb-0" style="font-size: 8px">Waktu Pesan: {{$item->created_at}} </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        
         setInterval(() => {
            fetch('/server-time')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('server-time').innerText = data.time;
                });
        }, 1000);

    </script>

@endsection