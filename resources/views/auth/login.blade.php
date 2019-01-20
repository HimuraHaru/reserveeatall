@extends('layouts.login')

@section('title')
    Reserve Eat All | Login
@endsection

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-title p-b-26">
						Login
					</span>
                    <span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>
                    @if ($errors->has('email'))
                        <span class="login100-form-title p-b-26" style="color:red">
						Incorrect details!
                        <br/>
                        <br/>
					</span>
                    @endif

                    @if(\Illuminate\Support\Facades\Request::input('referenceUrl') == "reserve" && \Illuminate\Support\Facades\Request::input('id') != NULL)
                        <input type="hidden" name="referenceUrl" value="reserve"/>
                        <input type="hidden" name="id" value="{{ \Illuminate\Support\Facades\Request::input('id') }}"/>
                    @endif

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                        <input id="email" type="text" class="input100" name="email" value="{{ old('email') }}" required autofocus>
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                        <input id="password" type="password" class="input100" name="password" required>
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" class="login100-form-btn">
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
						<span class="txt1">
							Don’t have an account?
						</span>

                        <a class="txt2" href="{{ route('register') }}">
                            Sign Up
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
