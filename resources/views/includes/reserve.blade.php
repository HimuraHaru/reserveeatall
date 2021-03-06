<!--== 15. Reserve A Table! ==-->
<section id="reserve" class="reserve">
    <img class="img-responsive section-icon hidden-sm hidden-xs" src="{{ asset('assets/images/icons/reserve_black.png') }}">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row dis-table">
                <div class="col-xs-6 col-sm-6 dis-table-cell color-bg">
                    <h2 class="section-title">Reserve A Table !</h2>
                </div>
                <div class="col-xs-6 col-sm-6 dis-table-cell section-bg">

                </div>
            </div> <!-- /.dis-table -->
        </div> <!-- /.row -->
    </div> <!-- /.wrapper -->
</section> <!-- /#reserve -->

<section class="reservation">
    <img class="img-responsive section-icon hidden-sm hidden-xs" src="{{ asset('assets/images/icons/reserve_color.png') }}">
    <div class="wrapper">
        <div class="container-fluid">
            <div class=" section-content">
                <div class="row">
                    <div class="col-md-5 col-sm-6">
                        @if(Auth::check() == false || Auth::user()->email_verified_at == NULL)
                        <form class="reservation-form" method="post" action="reserve.php">
                            @if(Auth::check() == false)
                            <b>Note: </b>
                            <span style="color:red">You need to login first before making a reservation.</span> <br/><br/>
                            @elseif(Auth::user()->email_verified_at == NULL)
                            <span style="color:red">Warning. Verify Your Email Address</span> <br/><br/>
                                <span style="color:red">Before proceeding, please check your email for a verification link. If you did not receive the email,
                                    <a href="{{ route('verification.resend') }}">click here to request another.</a>
                                </span> <br/><br/>
                            @endif
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" onfocus="(this.type='date')" class="form-control reserve-form empty iconified" name="datepicker" id="datepicker" required="required" placeholder="&#xf017;  Date" disabled>
                                    </div>
                                       <div class="form-group form-group form-control reserve-form">
                                    Available Seats: {{ $restaurant->restaurantSeatsAvail }}
                                        </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="number" disabled class="form-control reserve-form empty iconified" name="seats" id="seats" required="required" placeholder="&#xf0c0;  Number of seats">
                                    </div>
                                    <div class="form-group">
                                        <select type="text" class="form-control reserve-form empty iconified" name="time" id="time" required="required" placeholder="&#xf017;  Time" disabled>
                                            <option selected disabled>Choose your preferred time.</option>
                                            @for($i = 0; $i <= $time - 2; $i++)
                                                <option value="{{ $restaurant->openingTime + $i }}">{{ \App\Http\Helpers::convertTime($restaurant->openingTime + $i) }}</option>
                                            @endfor
                                        </select>
                                        {{--<input type="text" onfocus="(this.type='time')" class="form-control reserve-form empty iconified" name="time" id="time" required="required" placeholder="&#xf017;  Time">--}}
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <textarea type="text" name="message" class="form-control reserve-form empty iconified" id="message" rows="3" required="required" placeholder="  &#xf086;  We're listening" disabled></textarea>
                                </div>

                                @if(Auth::check() == false)
                                    <div class="col-md-12 col-sm-12">
                                         <a href="{{ route('login', 'referenceUrl=reserve&id=' . $restaurant->restaurantID ) }}" class="btn btn-reservation">
                                             <span><i class="fa fa-check-circle-o"></i></span>
                                             Login
                                         </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                        @elseif(Auth::check())
                            <form class="reservation-form" id="referenceUrl=reserve" method="post" action="{{ route('reserve', $restaurant->restaurantID ) }}">
                                @csrf
                                <input type="hidden" name="restaurantID" value="{{ $restaurant->restaurantID }}"/>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" onfocus="(this.type='date')" class="form-control reserve-form empty iconified" name="datepicker" id="datepicker" required="required" placeholder="&#xf017;  Date" min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                            {{--<input type="text" class="form-control reserve-form empty iconified" name="datepicker" id="datepicker" required="required" placeholder="&#xf017;  Date">--}}
                                        </div>
                                        <div class="form-group form-group form-control reserve-form">
                                    Available Seats: {{ $restaurant->restaurantSeatsAvail }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control reserve-form empty iconified" name="seats" id="seats" min="1" required="required" placeholder="&#xf0c0;  Number of seats">
                                        </div>
                                        
                                        <div class="form-group">
                                            <select type="text" class="form-control reserve-form empty iconified" name="time" id="time" required="required" placeholder="&#xf017;  Time" required>
                                                <option selected disabled>Choose your preferred time.</option>
                                                @for($i = 0; $i <= $time - 2; $i++)
                                                    <option value="{{ $restaurant->openingTime + $i }}">{{ \App\Http\Helpers::convertTime($restaurant->openingTime + $i) }}</option>
                                                @endfor
                                            </select>
                                            {{--<input type="text" onfocus="(this.type='time')" class="form-control reserve-form empty iconified" name="time" id="time" required="required" placeholder="&#xf017;  Time">--}}
                                        </div>

                                    </div>                       

                                    <div class="col-md-12 col-sm-12">
                                        <textarea type="text" name="message" class="form-control reserve-form empty iconified" id="message" rows="3" required="required" placeholder="  &#xf086;  We're listening"></textarea>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <button type="submit" id="submit" name="submit" class="btn btn-reservation">
                                            <span><i class="fa fa-check-circle-o"></i></span>
                                            Make a reservation.
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>

                    <div class="col-md-2 hidden-sm hidden-xs"></div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="opening-time">
                            <h3 class="opening-time-title">Operating Hours</h3>
                            <p>{{ \App\Http\Helpers::operatingHours($restaurant->openingTime, $restaurant->closingTime) }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>