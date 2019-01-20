@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ $restaurant->restaurantName }} - {{ $restaurant->restaurantAddress }} - Operating Hours: {{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}</h4>
                            <p class="card-category"> <a href="{{ route('add-food', $restaurant->restaurantID) }}">Add food</a></p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Price
                                    </th>
                                    <th>
                                        Main Ingredients
                                    </th>
                                    <th>
                                        Category
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                    </thead>
                                    <tbody>
                                    @foreach($foods as $food)
                                        <tr>
                                            <td>
                                                {{ $food->foodName }}
                                            </td>
                                            <td>
                                                {{ $food->foodPrice }}
                                            </td>
                                            <td>
                                                {{ $food->foodIngredient }}
                                            </td>
                                            <td>
                                                {{ $food->foodCategory }}
                                            </td>
                                            <td class="text-primary">
                                                <a href="{{ route('view-food', $food->foodID ) }}">VIEW/</a>
                                                <a href="{{ route('edit-food', $food->foodID ) }}">EDIT/</a>
                                                <a href="{{ route('delete-food', $food->foodID ) }}">DELETE</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr/>
                                <!--Paginate-->
                                <div>{{ $foods->links() }}</div>
                                <!--End of Paginate-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection