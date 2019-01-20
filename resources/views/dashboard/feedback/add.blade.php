@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Add Feedback</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('add-feedback-post', $reservation->reservationID) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Restaurant Name</label>
                                            <input type="text" disabled class="form-control" name="restaurantName" value="{{ $restaurant->restaurantName }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Message</label>
                                            <div class="form-group">
                                                <label class="bmd-label-floating"> Please enter your message here.</label>
                                                <textarea class="form-control" name="feedbackMessage" rows="5" required></textarea>
                                            </div>
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