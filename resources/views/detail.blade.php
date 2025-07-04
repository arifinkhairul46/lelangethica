@extends('layouts.app')

@section('content')
    <div class="container text-white">
        <div class="d-flex" style="justify-content: space-between">
            <div class="mt-1">
                <h6> Halo, {{auth()->user()->name}} </h6>
            </div>
            <img src="{{asset('assets/images/ethica_logo.png')}}" alt="logo-ethica" width="100" >
            <div class="mx-2">
                <a href="#" id="navbarDropdown"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user-circle fa-xl"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#" style="font-size: 13px">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <form role="form" method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <div
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="dropdown-item">Logout</span>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </div>

     <div id="image-carousel" class="carousel slide px-0">
        <div class="carousel-indicators">
            @foreach ($image_produk as $item )
                <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="{{$loop->iteration - 1}}" aria-current="true" aria-label="Slide {{$loop->iteration}}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($image_produk as $item )
                @if ($loop->iteration == 1 )
                    <div class="carousel-item active">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_produk) }}" alt="{{$item->image_produk}}" width="100%">
                    </div>
                @else
                    <div class="carousel-item">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_produk) }}" alt="{{$item->image_produk}}" width="100%">
                    </div>
                @endif
            @endforeach
            
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#image-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#image-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container">
    </div>

@endsection