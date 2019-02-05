@extends('layouts.master')

@section('title')
    Reserve Eat All | {{ $restaurant->restaurantName }}
@endsection

@section('content')

    <br/><br/><br/><br/><br/><br/>
    
    @include('includes.menu')

    @include('includes.reserve')

    @include('includes.featuredMenu')

    
@endsection