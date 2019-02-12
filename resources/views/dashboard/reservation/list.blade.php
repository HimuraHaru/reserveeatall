@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Reservations / {{ ucwords($category) }}</h4>
                            {{--<p class="card-category"> <a href="{{ route('add-restaurant') }}">Add restaurant</a></p>--}}
                        </div>
                        @if(\App\Http\Helpers::checkIfUser())
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>
                                        Restaurant
                                    </th>
                                    <th>
                                        Seats
                                    </th>
                                    <th>
                                        Time
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    @if($category == \App\Http\Helpers::pending() || $category == \App\Http\Helpers::completed())
                                    <th>
                                        Action
                                    </th>
                                    @endif
                                    </thead>
                                    <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>
                                                {{ ucwords($reservation->restaurantName) }}
                                            </td>
                                            <td>
                                                {{ $reservation->reservationSeats }}
                                            </td>
                                            <td>
                                                {{ \App\Http\Helpers::convertTime($reservation->reservationTime) }}
                                            </td>
                                            <td>
                                                {{ $reservation->reservationDate }}
                                            </td>
                                            <td>
                                                {{ ucwords($reservation->reservationStatus) }}
                                            </td>
                                            @if($category == \App\Http\Helpers::pending())
                                                <td class="text-primary">
                                                    <a href="{{ route('list-reservation-post', [\App\Http\Helpers::pending(), \App\Http\Helpers::canceled(), $reservation->reservationID] ) }}">Cancel</a>
                                                </td>
                                            @elseif($category == \App\Http\Helpers::completed())
                                                <td class="text-primary">
                                                    @if($reservation->feedbackStatus == \App\Http\Helpers::pending())
                                                    <a href="{{ route('add-feedback', $reservation->reservationID) }}">Give Feedback</a>
                                                    @elseif($reservation->feedbackStatus == \App\Http\Helpers::completed())
                                                    <a href="#">Feedback Received</a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--Paginate-->
                                <div>{{ $reservations->links() }}</div>
                                <!--End of Paginate-->
                            </div>
                        </div>
                        @elseif(\App\Http\Helpers::checkIfManager())
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Customer
                                        </th>
                                        <th>
                                            Seats
                                        </th>
                                        <th>
                                            Time
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        @if($category == \App\Http\Helpers::pending() || $category == \App\Http\Helpers::approved())
                                        <th>
                                            Action
                                        </th>
                                        @endif
                                        </thead>
                                        <tbody>
                                        @foreach($reservations as $reservation)
                                            <tr>
                                                <td>
                                                    {{ ucwords($reservation->name) }}
                                                </td>
                                                <td>
                                                    {{ $reservation->reservationSeats }}
                                                </td>
                                                <td>
                                                    {{ \App\Http\Helpers::convertTime($reservation->reservationTime) }}
                                                </td>
                                                <td>
                                                    {{ $reservation->reservationDate }}
                                                </td>
                                                <td>
                                                    {{ ucwords($reservation->reservationStatus) }}
                                                </td>
                                                <td>
                                                @if($category == \App\Http\Helpers::pending())
                                                <a href="{{ route('list-reservation-post', [\App\Http\Helpers::pending(), \App\Http\Helpers::approved(), $reservation->reservationID] ) }}">Approve / </a>
                                                <a href="{{ route('list-reservation-post', [\App\Http\Helpers::pending(), \App\Http\Helpers::canceled(), $reservation->reservationID] ) }}">Cancel</a>
                                                @elseif($category == \App\Http\Helpers::approved())
                                                <a href="{{ route('list-reservation-post', [\App\Http\Helpers::approved(), \App\Http\Helpers::completed(), $reservation->reservationID] ) }}">Check In </a>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!--Paginate-->
                                    <div>{{ $reservations->links() }}</div>
                                    <!--End of Paginate-->
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection