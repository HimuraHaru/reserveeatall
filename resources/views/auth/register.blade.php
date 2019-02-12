@extends('layouts.login')

@section('title')
    Reserve Eat All | Register
@endsection

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <span class="login100-form-title p-b-26">
						Register
					</span>
                    <span class="login100-form-title p-b-48">
                    <a class="logo" href="#"></a>
					</span>
                    @if ($errors->has('email'))
                        <span class="login100-form-title p-b-26" style="color:red">
                            Email is already taken!
                            <br/>
                            <br/>
                        </span>
                    @elseif ($errors->has('password'))
                        <span class="login100-form-title p-b-26" style="color:red">
                            Password does not match or it should be minimum of 6 characters!
                            <br/>
                            <br/>
                        </span>
                     @elseif ($errors->has('contact'))
                        <span class="login100-form-title p-b-26" style="color:red">
                            It should start with 639 and the number should be a length of 12!
                            <br/>
                            <br/>
                        </span>
                    @elseif ($errors->has('age'))
                        <span class="login100-form-title p-b-26" style="color:red">
                            You must be 17 years old above!
                            <br/>
                            <br/>
                        </span>
                    @endif

                    <div class="wrap-input100 validate-input" data-validate="Enter first name">
                        <input id="firstName" type="text" class="input100" name="firstName" value="{{ old('firstName') }}" required autofocus>
                        <span class="focus-input100" data-placeholder="First Name"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter last name">
                        <input id="lastName" type="text" class="input100" name="lastName" value="{{ old('lastName') }}" required autofocus>
                        <span class="focus-input100" data-placeholder="Last Name"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Select gender">
                        <select id="gender" type="text" class="input100" name="gender" required autofocus>
                            @if(empty(old('gender')))
                                <option selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            @else
                                @if(old('gender') == "Male")
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                @elseif(old('gender') == "Female")
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                @endif
                            @endif
                        </select>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter age">
                        <input id="age" type="number" class="input100" name="age" value="{{ old('age') }}" required autofocus>
                        <span class="focus-input100" data-placeholder="Enter age"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter address">
                        <input id="address" type="text" class="input100" name="address" value="{{ old('address') }}" required autofocus>
                        <span class="focus-input100" data-placeholder="Enter address"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                        <input id="email" type="email" class="input100" name="email" value="{{ old('email') }}" required autofocus>
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input id="password" type="password" class="input100" name="password" required>
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter confirm password">
                        <input id="password-confirm" type="password" class="input100" name="password_confirmation" required>
                        <span class="focus-input100" data-placeholder="Confirm Password"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter contact number">
                        @if(!empty(old('contact')))
                            <input id="contact" type="text" class="input100" name="contact" value="{{old('contact')}}" required autofocus autofocus>
                        @else
                            <input id="contact" type="text" class="input100" name="contact" value="63" required autofocus autofocus>
                        @endif
                        <span class="focus-input100" data-placeholder="Enter contact number"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" class="login100-form-btn">
                                Register
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
						<span class="txt1">
							Already have an account?
						</span>

                        <a class="txt2" href="{{ route('login') }}">
                            Login
                        </a>

                        <br/>

                        <span class="txt1">
							Forgot your password?
						</span>

                        <a class="txt2" href="{{ route('password.request') }}">
                            Reset
                        </a>

                        <br/>
                        <span class="txt1">
                            <a class="txt2" href="{{ route('restaurant') }}">Back to restaurants.</a>
						</span>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>
@endsection
