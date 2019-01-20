@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Edit {{ $convertCategory }}</h4>
                        </div>
                        <div class="card-body">
                        <br/>
                            <form method="POST" action="{{ route('edit-account-post', [strtolower($convertCategory), $user->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        @if ($errors->has('name'))
                                            <span style="color:red">
                                                Maximum of 255 characters only!
                                            </span>
                                            <br/><br/>
                                        @elseif ($errors->has('email'))
                                            <span style="color:red">
                                                Email is already taken!
                                            </span>
                                            <br/><br/>
                                        @elseif (session()->has('invalidPassword'))
                                            <span style="color:red">
                                                {{ session()->get('invalidPassword') }}
                                            </span>
                                            <br/><br/>
                                        @elseif ($errors->has('password'))
                                            <span style="color:red">
                                                Password does not match or it should be minimum of 6 characters!
                                            </span>
                                            <br/><br/>
                                        @elseif ($errors->has('contact'))
                                            <span style="color:red">
                                                It should start with 639 and the number should be a length of 12!
                                            </span>
                                            <br/><br/>
                                        @elseif ($errors->has('profileImage'))
                                            <span style="color:red">
                                                The image should be jpeg, jpg and png only!
                                            </span>
                                            <br/><br/>
                                        @endif
                                        <div class="form-group">
                                            @if($convertCategory == "Name")
                                                <label class="bmd-label-floating">Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            @elseif($convertCategory == "Email")

                                                <label class="bmd-label-floating">Email</label>
                                                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                            @elseif($convertCategory == "Password")

                                                <label class="bmd-label-floating">Current Password</label>
                                                <input type="password" name="current" class="form-control">
                                            @elseif($convertCategory == "Contact")

                                                <label class="bmd-label-floating">Contact</label>
                                                <input type="text" name="contact" class="form-control" value="{{ $user->contact }}">
                                            @elseif($convertCategory == "Image")

                                                <label class="bmd-label-floating">Profile Image</label>
                                            @elseif($convertCategory == "Gender")
                                                <label class="bmd-label-floating">Gender</label>
                                                <select type="text" name="gender" class="form-control" required>
                                                    @if($user->gender == "Male")
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    @elseif($user->gender == "Female")
                                                        <option value="Female">Female</option>
                                                        <option value="Male">Male</option>
                                                    @endif
                                                </select>
                                            @elseif($convertCategory == "Age")
                                                 <label class="bmd-label-floating">Age</label>
                                                 <input type="text" name="age" class="form-control" value="{{ $user->age }}" required>
                                            @elseif($convertCategory == "Address")
                                                <label class="bmd-label-floating">Address</label>
                                                <input type="text" name="address" class="form-control" value="{{ $user->address }}" required>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($convertCategory == "Password")
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">New Password</label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($convertCategory == "Image")
                                    <input type="file" name="profileImage" required>
                                @endif

                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                <a href="{{ route('account') }}" class="btn btn-primary pull-right">Back</a>
                            </form>

                            <div class="clearfix"></div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#">
                                @if($user->profileImage == NULL)
                                    <img class="img" src="{{ asset('storage/assets/admin/img/users/no_image.jpg') }}" />
                                @else
                                    <img class="img" src="{{ asset('storage/assets/admin/img/users/' . $user->profileImage ) }}" />
                                @endif
                            </a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray">Account Type: {{ $user->role }}</h6>
                            <h6 class="card-category text-gray">Account Status: Verified</h6>
                            <h4 class="card-title">Name: {{ $user->name }}</h4>
                            <br/>
                            <a href="{{ route('edit-account', 'image') }}" class="btn btn-primary btn-round">EDIT PROFILE PICTURE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection