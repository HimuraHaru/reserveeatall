@extends('layouts.dashboard')

@section('content')
    @if(\App\Http\Helpers::checkIfAdmin())
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Logs</h4>
                                {{--<p class="card-category"> <a href="{{ route('add-restaurant') }}">Add restaurant</a></p>--}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Reservation ID
                                        </th>
                                        <th>
                                            Restaurant Name
                                        </th>
                                        <th>
                                            Client Name
                                        </th>
                                        <th>
                                            Created At
                                        </th>
                                        </thead>
                                        <tbody>
                                        @foreach($logs as $log)
                                            <tr>
                                                <td>
                                                    {{ $log->logID }}
                                                </td>
                                                <td>
                                                    {{ \App\Restaurant::findOrFail(\App\Reservation::findOrFail($log->reservationID)->restaurantID)->restaurantName }}
                                                </td>
                                                <td>
                                                    {{ \App\User::findOrFail(\App\Reservation::findOrFail($log->reservationID)->userID)->name }}
                                                </td>
                                                <td>
                                                    {{ $log->created_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <!--Paginate-->
                                    <div>{{ $logs->links() }}</div>
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
                                <h4 class="card-title ">Logs</h4>
                                {{--<p class="card-category"> <a href="{{ route('add-restaurant') }}">Add restaurant</a></p>--}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Reservation ID
                                        </th>
                                        <th>
                                            Restaurant Name
                                        </th>
                                        <th>
                                            Client Name
                                        </th>
                                        <th>
                                            Created At
                                        </th>
                                        </thead>
                                        <tbody>
                                        @foreach($logs as $log)
                                            <tr>
                                                <td>
                                                    {{ $log->logID }}
                                                </td>
                                                <td>
                                                    {{ \App\Restaurant::findOrFail($log->restaurantID)->restaurantName }}
                                                </td>
                                                <td>
                                                    {{ \App\User::findOrFail(\App\Reservation::findOrFail($log->reservationID)->userID)->name }}
                                                </td>
                                                <td>
                                                    {{ $log->created_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <!--Paginate-->
                                    {{--<div>{{ $data->links() }}</div>--}}
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