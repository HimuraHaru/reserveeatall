@extends('layouts.master')

@section('title')
    Reserve Eat All | Restaurants
@endsection

@section('content')

    <br/><br/><br/><br/><br/><br/>
    <section id="pricing" class="pricing">
        <div class="container">
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
                            </li>
                        @endforeach
                    </ul>

                    <!-- <div class="text-center">
                            <a id="loadPricingContent" class="btn btn-middle hidden-sm hidden-xs">Load More <span class="caret"></span></a>
                    </div> -->

                </div>
            </div>
        </div>

        </div>
    </section>

@endsection