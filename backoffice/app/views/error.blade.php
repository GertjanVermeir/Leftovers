@extends('layouts.master')

@section('title')
LEftovers
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
        <h1>Whoops!</h1>
        <p>It seems this page doesn't exist!</p>
        <img src="http://i.imgur.com/kkpSWqk.gif" alt="" width="100%"/>
        <br/><br/>
        <p><a href="{{ route('UberIndex') }}" class="btn btn-lg btn-primary btn-block">Go back to the admin center</a></p>
    </div>
</div>
@stop