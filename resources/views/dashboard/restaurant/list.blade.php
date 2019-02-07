@extends('layouts.dashboard')

@section('content')
    @if(\App\Http\Helpers::checkIfAdmin())
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Restaurants</h4>
                                <p class="card-category"> <a href="{{ route('add-restaurant') }}">Add restaurant</a></p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                        <th>
                                            Operating Hours
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                        </thead>
                                        <tbody>
                                        @foreach($restaurants as $restaurant)
                                            <tr>
                                                <td>
                                                    {{ $restaurant->restaurantName }}
                                                </td>
                                                <td>
                                                    {{ $restaurant->restaurantAddress }}
                                                </td>
                                                <td>
                                                    {{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}
                                                </td>
                                                <td class="text-primary">
                                                    {{--<a href="{{ route('view-menu', $restaurant->restaurantID ) }}">MENU/</a>--}}
                                                    <a href="{{ route('edit-restaurant', $restaurant->restaurantID ) }}">EDIT/</a>
                                                    <a href="{{ route('delete-restaurant', $restaurant->restaurantID ) }}">DELETE</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <!--Paginate-->
                                    <div>{{ $restaurants->links() }}</div>
                                    <!--End of Paginate-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(\App\Http\Helpers::checkIfManager())
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Manage Restaurant</h4>
                                {{--<p class="card-category"> <a href="{{ route('add-restaurant') }}">Add restaurant</a></p>--}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                        <th>
                                            Operating Hours
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $restaurant->restaurantName }}
                                                </td>
                                                <td>
                                                    {{ $restaurant->restaurantAddress }}
                                                </td>
                                                <td>
                                                    {{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}
                                                </td>
                                                <td class="text-primary">
                                                    <a href="{{ route('view-menu', $restaurant->restaurantID ) }}">MENU / </a>
                                                    <a href="{{ route('edit-restaurant', $restaurant->restaurantID ) }}">EDIT</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection