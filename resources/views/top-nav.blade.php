<div class="container text-white sticky-top" style="background-color: #1f1f1f">
    <div class="d-flex" style="justify-content: space-between">
        @if ( auth()->user() )
            <div class="mt-1" style="max-width: 30%">
                <h6 class="mb-1" style="font-size: 14px"> Halo, {{auth()->user()->name}} </h6>
                <div id="server-time" style="font-size: 10px"></div>
            </div>
            <a href="{{route('index')}}"> <img src="{{asset('assets/images/ethica_logo.png')}}" alt="logo-ethica" width="100" style="max-height: 40px" > </a>
            <div class="mt-1 mx-2">
                <a href="#" id="navbarDropdown" style="color: #BCAA97" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user-circle fa-xl"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#" style="font-size: 13px">Profile</a></li>
                    <li><a class="dropdown-item" href="{{route('order_history')}}" style="font-size: 13px">Orders</a></li>
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
        @else 
            <div class="mt-2" id="server-time" style="font-size: 10px"></div>
            <img src="{{asset('assets/images/ethica_logo.png')}}" alt="logo-ethica" width="100" >
            <div class="mt-2 mx-2">
                <a href="{{route('login')}}"> <button class="btn btn-sm btn-cream"> Login </button> </a>
            </div>
        @endif
    </div>
</div>