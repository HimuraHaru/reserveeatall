@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Generated Statistics for {{ $restaurantID->restaurantName }}</h4>
                        </div>

                        <div class="card-body">

                            @if($reservations->where('reservationStatus', 'completed')->count() == 0 && $reservations->where('reservationStatus', 'canceled')->count() == 0)

                                <div class="alert">
                                    <span style="color:red;">No statistics found!</span>
                                </div>

                            @else
                            <div id="piechart"></div>
                            <script type="text/javascript" src="{{ asset('assets/admin/js/chart.js') }}"></script>

                            <script type="text/javascript">
                                // Load google charts
                                google.charts.load('current', {'packages':['corechart']});
                                google.charts.setOnLoadCallback(drawChart);

                                google.charts.load('current', {'packages':['corechart']});
                                google.charts.setOnLoadCallback(drawChart);
                                // Draw the chart and set the chart values
                                function drawChart() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Gender', 'Gender'],
                                        ['Male', {{ $male }}],
                                        ['Female', {{ $female }}],
                                        ['Completed', {{ $reservations->where('reservationStatus', 'completed')->count() }}],
                                        ['Canceled', {{ $reservations->where('reservationStatus', 'canceled')->count() }}],
                                    ]);

                                    // Optional; add a title and set the width and height of the chart
                                    var options = {'title':'Statistics for {{ $date }}', 'width':550, 'height':400};

                                    // Display the chart inside the <div> element with id="piechart"
                                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                    chart.draw(data, options);
                                }
                                </script>
                            @endif

                                <a href="{{ route('statistics') }}" class="btn btn-primary pull-right">Back</a>
                                <div class="clearfix"></div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Male
                                        </th>
                                        <th>
                                            Female
                                        </th>
                                        <th>
                                            Completed
                                        </th>
                                        <th>
                                            Canceled
                                        </th>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>
                                                    {{ $male }}
                                                </td>
                                                <td>
                                                    {{ $female }}
                                                </td>
                                                <td>
                                                    {{ $reservations->where('reservationStatus', 'completed')->where('restaurantID', $restaurantID)->count() }}
                                                </td>
                                                <td>
                                                    {{ $reservations->where('reservationStatus', 'canceled')->where('$restaurantID', $restaurantID)->count() }}
                                                </td>
                                                {{--<td class="text-primary">--}}
                                                {{--<a href="{{ route('view-menu', $restaurant->restaurantID ) }}">MENU/</a>--}}
                                                {{--<a href="{{ route('edit-restaurant', $restaurant->restaurantID ) }}">EDIT/</a>--}}
                                                {{--<a href="{{ route('delete-restaurant', $restaurant->restaurantID ) }}">DELETE</a>--}}
                                                {{--</td>--}}
                                            </tr>

                                        </tbody>
                                    </table>
                                    <hr/>
                                </div>

                         </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection