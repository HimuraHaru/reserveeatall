@extends('layouts.master')

@section('title')
    Reserve Eat All | Restaurants
@endsection

@section('content')

@include('slider')
    
    <section id="pricing" class="pricing">
        <div class="container">
            <br/>
            <form class="search" method="GET">
                <input type="text" name="search" placeholder="Enter restaurant name">
                <button>SEARCH</button>
            </form>
            @if(\Illuminate\Support\Facades\Session::get('getData') != NULL)
                @if(\Illuminate\Support\Facades\Session::get('getData')->count() != 0)
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <ul id="menu-pricing" class="menu-price">
                                @foreach(\Illuminate\Support\Facades\Session::get('getData') as $restaurant)
                                    <li class="menus dinner">
                                        <a href="{{ route('view-restaurant', $restaurant->restaurantID) }}">
                                            <img alt="nepoquad_restaurant_logo"src="{{ asset('storage/assets/admin/img/restaurants/'.$restaurant->restaurantLogo) }}" class="img-responsive" alt="" >
                                        </a>
                                        
                                        <h2 class="white">{{ $restaurant->restaurantName }}</h2>
                                        <h3>Opens {{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}</h3>
                                        <h4>{{ $restaurant->restaurantAddress }}</h4>
                                    </li>
                                    
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <ul id="menu-pricing" class="menu-price">
                                <div class="alert alert-danger" role="alert">There's no restaurant available!</div>
                            </ul>
                        </div>
                    </div>
                @endif
            @elseif($restaurants->count() >= 1)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <ul id="menu-pricing" class="menu-price">
                            @foreach($restaurants as $restaurant)
                                <li class="menus dinner">
                                    <a href="{{ route('view-restaurant', $restaurant->restaurantID) }}">
                                        <img alt="nepoquad_restaurant_logo" src="{{ asset('storage/assets/admin/img/restaurants/'.$restaurant->restaurantLogo) }}" class="img-responsive" alt="" >
                                    </a>

                                    <h2 class="white">{{ $restaurant->restaurantName }}</h2>
                                    <h3>Opens {{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}</h3>
                                    <h4>{{ $restaurant->restaurantAddress }}</h4>
                                    <br/><br/>
                                    <div class="star_alignment_container">
                                        <!-- Call the JavaScript Function with Percentage of your rating (0-100)-->
                                        <script>rate({{ \App\Http\Helpers::ratings($restaurant->restaurantID) }});</script>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        </div>
    </section>

<!--Indexing purpose-->
<section id="search"></section>


    
    @include('includes.about')

@endsection