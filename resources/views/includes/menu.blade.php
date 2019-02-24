<!--==  7. Afordable Pricing  ==-->
<section id="pricing" class="pricing">
    <div id="w">
        <div class="pricing-filter">
            <div class="pricing-filter-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="section-header">
                                <h2 class="pricing-title">{{ $restaurant->restaurantName }}'s Menu.</h2>
                                {{--<h3 class="pricing-title">Operating Hours: {{ $restaurant->operatingHours }}</h3>--}}
                                <ul id="filter-list" class="clearfix">
                                    <li class="filter" data-filter="all">All</li>
                                    <li class="filter" data-filter=".breakfast">Breakfast</li>
                                    <li class="filter" data-filter=".special">Special</li>
                                    <li class="filter" data-filter=".desert">Desert</li>
                                    <li class="filter" data-filter=".dinner">Dinner</li>
                                </ul><!-- @end #filter-list -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <br/>
            <form class="search" method="GET">
                <input type="text" name="search" placeholder="Enter food name">
                <button>SEARCH</button>
            </form>

            @if($foods->count() >= 1)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <ul id="menu-pricing" class="menu-price">
                            @foreach($foods as $food)
                                <li class="item {{ $food->foodCategory }}">

                                    <a href="#">
                                        <img alt="nepoquad_restaurant_food_image" src="{{ asset('storage/assets/admin/img/restaurants/foods/' . $food->foodImage ) }}" class="img-responsive" alt="Food" >
                                        <div class="menu-desc text-center">
                                                <span>
                                                    <h3>{{ $food->foodName }}</h3>
                                                    {{ $food->foodIngredient }}
                                                </span>
                                        </div>
                                    </a>

                                    <h2 class="white">₱{{ $food->foodPrice }}</h2>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <ul id="menu-pricing" class="menu-price">
                            <div class="alert alert-danger" role="alert">There's no food available!</div>
                        </ul>
                    </div>
                </div>
            @endif
        </div>

    </div>
</section>