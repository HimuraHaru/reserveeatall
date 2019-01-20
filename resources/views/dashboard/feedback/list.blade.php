@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if(\App\Http\Helpers::checkIfUser())
                         <div class="card-header card-header-primary">
                             <h4 class="card-title ">Feedbacks / History</h4>
                         </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>
                                        Restaurant Name
                                    </th>
                                    <th>
                                        Message
                                    </th>
                                    <th>
                                        Reservation Date
                                    </th>
                                    </thead>
                                    <tbody>
                                    @foreach($feedbacks as $feedback)
                                        <tr>
                                            <td>
                                                {{ \App\Restaurant::findOrFail(\App\Reservation::findOrFail($feedback->reservationID)->restaurantID)->restaurantName }}
                                            </td>
                                            <td>
                                                {{ $feedback->feedbackMessage }}
                                            </td>
                                            <td>
                                                {{ \App\Reservation::findOrFail($feedback->reservationID)->reservationDate }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr/>
                                <!--Paginate-->
                                <div>{{ $feedbacks->links() }}</div>
                                <!--End of Paginate-->
                            </div>
                        </div>
                        @elseif(\App\Http\Helpers::checkIfManager())
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Feedbacks / {{ $restaurant->restaurantName }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Customer Name
                                        </th>
                                        <th>
                                            Message
                                        </th>
                                        <th>
                                            Reservation Date
                                        </th>
                                        </thead>
                                        <tbody>
                                        @foreach($feedbacks as $feedback)
                                            <tr>
                                                <td>
                                                    {{ ucwords(\App\User::findOrFail($feedback->userID)->name) }}
                                                </td>
                                                <td>
                                                    {{ ucfirst($feedback->feedbackMessage) }}
                                                </td>
                                                <td>
                                                    {{ $feedback->reservationDate }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <!--Paginate-->
                                    <div>{{ $feedbacks->links() }}</div>
                                    <!--End of Paginate-->
                                </div>
                            </div>
                            @elseif(\App\Http\Helpers::checkIfAdmin())
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title ">Feedbacks</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                <th>
                                                    Restaurant Name
                                                </th>
                                                <th>
                                                    Customer Name
                                                </th>
                                                <th>
                                                    Message
                                                </th>
                                                <th>
                                                    Reservation Date
                                                </th>
                                                </thead>
                                                <tbody>
                                                @foreach($feedbacks as $feedback)
                                                    <tr>
                                                        <td>
                                                            {{ \App\Restaurant::findOrFail(\App\Reservation::findOrFail($feedback->reservationID)->restaurantID)->restaurantName }}
                                                        </td>
                                                        <td>
                                                            {{ ucwords(\App\User::findOrFail($feedback->userID)->name) }}
                                                        </td>
                                                        <td>
                                                            {{ ucfirst($feedback->feedbackMessage) }}
                                                        </td>
                                                        <td>
                                                            {{ \App\Reservation::findOrFail($feedback->reservationID)->reservationDate }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr/>
                                            <!--Paginate-->
                                            <div>{{ $feedbacks->links() }}</div>
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