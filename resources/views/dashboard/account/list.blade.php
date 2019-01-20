@extends('layouts.dashboard')

@section('content')
    @if(\App\Http\Helpers::checkIfAdmin())
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Accounts</h4>
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
                                            Gender
                                        </th>
                                        <th>
                                            Age
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Contact
                                        </th>
                                        <th>
                                            Role
                                        </th>
                                        </thead>
                                        <tbody>
                                        @foreach($accounts as $account)
                                            <tr>
                                                <td>
                                                    {{ $account->name }}
                                                </td>
                                                <td>
                                                    {{ $account->gender }}
                                                </td>
                                                <td>
                                                    {{ $account->age }}
                                                </td>
                                                <td>
                                                    {{ $account->contact }}
                                                </td>
                                                <td>
                                                    {{ $account->email }}
                                                </td>
                                                <td>
                                                    {{ $account->role }}
                                                </td>
                                                {{--<td class="text-primary">--}}
                                                    {{--<a href="{{ route('view-menu', $restaurant->restaurantID ) }}">MENU/</a>--}}
                                                    {{--<a href="{{ route('edit-restaurant', $restaurant->restaurantID ) }}">EDIT/</a>--}}
                                                    {{--<a href="{{ route('delete-restaurant', $restaurant->restaurantID ) }}">DELETE</a>--}}
                                                {{--</td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <!--Paginate-->
                                    <div>{{ $accounts->links() }}</div>
                                    <!--End of Paginate-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection