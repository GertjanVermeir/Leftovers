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
        <h1>We're sorry.</h1>
        <p>It seems you aren't allowed to enter this section of the Leftovers app.</p>
        <p>Your current role is: {{ Auth::user()->role->name }}</p>
        <a href="{{ route('UberIndex') }}" class="btn btn-lg btn-primary btn-block">Go back to the admin center</a>
    </div>
</div>
@stop