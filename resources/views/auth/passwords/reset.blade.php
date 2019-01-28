@extends('layouts.login')

@section('title')
    Reserve Eat All | Register
@endsection

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <span class="login100-form-title p-b-26">
						Reset Password
					</span>
                    <span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>
                    @if ($errors->has('email'))
                        <span class="login100-form-title p-b-26" style="color:red">
                            {{ $errors->first('email') }}
                            <br/>
                            <br/>
                        </span>
                    @elseif ($errors->has('password'))
                        <span class="login100-form-title p-b-26" style="color:red">
                            {{ $errors->first('password') }}
                            <br/>
                            <br/>
                        </span>

                    @endif

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

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" class="login100-form-btn">
                                Reset Password
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
							Don't have an account?
						</span>

                        <a class="txt2" href="{{ route('register') }}">
                            Register
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
@endsection