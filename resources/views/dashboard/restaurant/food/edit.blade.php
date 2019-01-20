@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Edit food</h4>

                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('edit-food-post', $food->foodID) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ $food->foodName }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Price</label>
                                            <input type="number" class="form-control" name="price" value="{{ $food->foodPrice }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Main Ingredient</label>
                                            <input type="text" class="form-control" name="mainIngredient" value="{{ $food->foodIngredient }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Category</label>
                                            <select class="form-control" name="category" required>
                                                @if($food->foodCategory == "breakfast")
                                                <option value="breakfast">Breakfast</option>
                                                <option value="special">Special</option>
                                                <option value="desert">Desert</option>
                                                <option value="dinner">Dinner</option>
                                                @elseif($food->foodCategory == "special")
                                                 <option value="special">Special</option>
                                                 <option value="desert">Desert</option>
                                                 <option value="dinner">Dinner</option>
                                                 <option value="breakfast">Breakfast</option>
                                                @elseif($food->foodCategory == "dinner")
                                                 <option value="dinner">Dinner</option
                                                 <option value="desert">Desert</option>
                                                 <option value="breakfast">Breakfast</option>
                                                 <option value="special">Special</option>
                                                @elseif($food->foodCategory == "desert")
                                                 <option value="desert">Desert</option>
                                                 <option value="breakfast">Breakfast</option>
                                                 <option value="special">Special</option>
                                                 <option value="dinner">Dinner</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Image</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="logo">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Food Preview</label>
                                            <img src="{{ asset('storage/assets/admin/img/restaurants/foods/'.$food->foodImage) }}"/>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                <a href="{{ route('view-menu', $food->restaurantID ) }}" class="btn btn-primary pull-right">Back</a>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="{{ route('view-menu', $restaurant->restaurantID) }}">
                                <img class="img" src="{{ asset('storage/assets/admin/img/restaurants/' . $restaurant->restaurantLogo) }}" />
                            </a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray">{{ $restaurant->restaurantName }}</h6>
                            <h4 class="card-title">{{ $restaurant->restaurantAddress }}</h4>
                            <p></p>
                            <p class="card-description">
                                Operating Hours: {{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}
                            </p>
                            <a href="{{ route('edit-restaurant', $restaurant->restaurantID) }}" class="btn btn-primary btn-round">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection