@extends('layouts.login')

@section('title')
    Reserve Eat All | Register
@endsection

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <span class="login100-form-title p-b-26">
						Reset Password
					</span>
                    <span class="login100-form-title p-b-48">
                    <a class="logo" href="http://reserve-eatall.com/"></a>
					</span>
                    @if ($errors->has('email'))
                        <span class="login100-form-title p-b-26" style="color:red">
                            {{ $errors->first('email') }}
                            <br/>
                            <br/>
                        </span>
                    @endif

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                        <input id="email" type="email" class="input100" name="email" value="{{ old('email') }}" required autofocus>
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" class="login100-form-btn">
                                Send Password Reset Link
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
							Create Account?
						</span>

                        <a class="txt2" href="{{ route('register') }}">
                            Signup
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