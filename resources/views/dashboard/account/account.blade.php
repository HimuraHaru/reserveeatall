@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Account</h4>
                        </div>
                        <div class="card-body">
                            <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Name</label>
                                            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('edit-account', 'name') }}">
                                            <button class="btn btn-primary btn-round">EDIT</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Gender</label>
                                            <input type="text" class="form-control" value="{{ $user->gender }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('edit-account', 'gender') }}">
                                            <button class="btn btn-primary btn-round">EDIT</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Age</label>
                                            <input type="text" class="form-control" value="{{ $user->age }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('edit-account', 'age') }}">
                                            <button class="btn btn-primary btn-round">EDIT</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Address</label>
                                            <input type="text" class="form-control" value="{{ $user->address }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('edit-account', 'address') }}">
                                            <button class="btn btn-primary btn-round">EDIT</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Email</label>
                                            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('edit-account', 'email') }}">
                                            <button class="btn btn-primary btn-round">EDIT</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Password</label>
                                            <input type="password" class="form-control" value="{{ $user->password }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('edit-account', 'password') }}">
                                            <button class="btn btn-primary btn-round">EDIT</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Contact</label>
                                            <input type="text" class="form-control" value="{{ $user->contact }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('edit-account', 'contact') }}">
                                            <button class="btn btn-primary btn-round">EDIT</button>
                                        </a>
                                    </div>
                                </div>
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