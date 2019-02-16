@extends('layouts.master')

@section('title')
    Reserve Eat All | Restaurants
@endsection

@section('content')

@include('slider')
    
    <section id="pricing" class="pricing">
        <div class="container">
            <br/>
            <form method="GET">
                <input type="text" name="search" placeholder="Enter restaurant name">
                <button>SEARCH</button>
            </form>
            @if(\Illuminate\Support\Facades\Session::get('getData') != NULL)
                @if(\Illuminate\Support\Facades\Session::get('getData')->count() != 0)
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <ul id="menu-pricing" class="menu-price">
                                @foreach(\Illuminate\Support\Facades\Session::get('getData') as $restaurant)
                                    <li class="item dinner">
                                        <a href="{{ route('view-restaurant', $restaurant->restaurantID) }}">
                                            <img src="{{ asset('storage/assets/admin/img/restaurants/'.$restaurant->restaurantLogo) }}" class="img-responsive" alt="" >
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
                                <li class="item dinner">
                                    <a href="{{ route('view-restaurant', $restaurant->restaurantID) }}">
                                        <img src="{{ asset('storage/assets/admin/img/restaurants/'.$restaurant->restaurantLogo) }}" class="img-responsive" alt="" >
                                    </a>

                                    <h2 class="white">{{ $restaurant->restaurantName }}</h2>
                                    <h3>Opens {{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}</h3>
                                    <h4>{{ $restaurant->restaurantAddress }}</h4>
                                    <br/><br/>
                                    <h4>Stars: {{ \App\Http\Helpers::ratings($restaurant->restaurantID) }}</h4>
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