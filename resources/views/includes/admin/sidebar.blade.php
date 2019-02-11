<div class="sidebar" data-color="green" data-background-color="white" data-image="{{ asset('assets/admin/img/sidebar-1.jpg') }}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo">
        <a href="{{ route('restaurant') }}" class="simple-text logo-normal">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> RESERVE EAT ALL
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item active  ">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            {{--<li class="nav-item ">--}}
                {{--<a class="nav-link" href="./user.html">--}}
                    {{--<i class="material-icons">person</i>--}}
                    {{--<p>User Profile</p>--}}
                {{--</a>--}}
            {{--</li>--}}
            @if(Auth::user()->role == "ADMIN")
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('list-restaurant') }}">
                        <i class="material-icons">restaurant</i>
                        <p>Restaurants</p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route('statistics') }}" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">rate_review</i>
                        <p>Statistics</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('account-list') }}">
                        <i class="material-icons">account_box</i>
                        <p>Accounts</p>
                    </a>
                </li>
                {{--<li class="nav-item dropdown">--}}
                    {{--<a class="nav-link" href="#" id="reservationOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        {{--<i class="material-icons">content_paste</i>--}}
                        {{--<p>Reservations</p>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="reservationOptions">--}}
                        {{--<a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::pending()) }}">Pending</a>--}}
                        {{--<a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::approved()) }}">Approved</a>--}}
                        {{--<a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::completed()) }}">Completed</a>--}}
                    {{--</div>--}}
                {{--</li>--}}
            @elseif(Auth::user()->role == "MANAGER")
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('list-restaurant') }}">
                        <i class="material-icons">restaurant_menu</i>
                        <p>Restaurants</p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="reservationOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">content_paste</i>
                        <p>Reservations</p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reservationOptions">
                        <a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::pending()) }}">Pending</a>
                        <a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::approved()) }}">Approved</a>
                        <a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::completed()) }}">Completed</a>
                    </div>
                </li>
            @elseif(Auth::user()->role == "USER")
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="reservationOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">content_paste</i>
                        <p>Reservations</p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reservationOptions">
                        <a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::pending()) }}">Pending</a>
                        <a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::approved()) }}">Approved</a>
                        <a class="dropdown-item" href="{{ route('list-reservation', \App\Http\Helpers::completed()) }}">Completed</a>
                    </div>
                </li>
            @endif
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('list-feedback') }}">
                    <i class="material-icons">feedback</i>
                    <p>Feedbacks</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('account') }}">
                    <i class="material-icons">persons</i>
                    <p>Profile</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <i class="material-icons">logout</i>
                    <p>Logout</p>
                    <!--Logout-->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!--Logout-->
                </a>
            </li>
        </ul>
    </div>
</div>