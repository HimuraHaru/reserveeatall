@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Edit Restaurant</h4>

                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('edit-restaurant-post', $restaurant->restaurantID) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ $restaurant->restaurantName }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ $restaurant->restaurantAddress }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select class="form-control" name="openingTime" required>
                                                <option selected value="{{ $restaurant->openingTime }}">{{ \App\Http\Helpers::convertTime($restaurant->openingTime) }}</option>
                                                @include('includes.admin.time')
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select class="form-control" name="closingTime" required>
                                                <option selected value="{{ $restaurant->closingTime }}">{{ \App\Http\Helpers::convertTime($restaurant->closingTime) }}</option>
                                                @include('includes.admin.time')
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Logo</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="logo">

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Logo Preview</label>
                                            <img src="{{ asset('storage/assets/admin/img/restaurants/'.$restaurant->restaurantLogo) }}"/>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                <a href="{{ route('list-restaurant') }}" class="btn btn-primary pull-right">Back</a>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection