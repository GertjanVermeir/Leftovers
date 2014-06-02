@extends('layouts.master')

@section('title')
Leftovers
@stop

@section('additional_styles')
<style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
</style>
@stop

@section('content')
<div class="container">
    <div class="form-signin">
        <h1>Leftovers Admin Center</h1>

        @if (Auth::user())
        @if (Auth::user()->role == "Administrator")
        <p><a href="{{ route('admin') }}" class="btn btn-lg btn-success btn-block">Admin Dashboard</a></p>
        @elseif (Auth::user()->role->name == "Store")
        <p><a href="{{ route('store') }}" class="btn btn-lg btn-success btn-block">Store Dashboard</a></p>
        @else
        <p>Hello user! You can't do much here 'cause you don't have the permission to do so. Sorry! Please log out.</p>
        @endif


        <p><a href="{{ route('user.logout') }}" class="btn btn-lg btn-danger btn-block">Logout</a></p>
        @else
        <p><a href="{{ route('user.login') }}" class="btn btn-lg btn-primary btn-block">Login</a></p>
        @endif
    </div>


@stop

@section('additional_scripts')

@stop
