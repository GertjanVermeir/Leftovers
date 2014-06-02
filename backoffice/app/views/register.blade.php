@extends('layouts.master')

@section('title')
Leftovers - Aanmelden
@stop

@section('additional_styles')
<style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }
    .form-register {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-register .form-signin-heading,
    .form-register .checkbox {
        margin-bottom: 10px;
    }
    .form-register .checkbox {
        font-weight: normal;
    }
    .form-register .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-register .form-control:focus {
        z-index: 2;
    }
    .form-register input[type="text"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-register input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
@stop

@section('content')
<div class="container">
    {{ Form::open(['route' => 'user.auth', 'class' => 'form-register']), PHP_EOL }}

    <h2>Registreren</h2>

    @if(count($errors) != 0)
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    @if($errors->first('name'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::text('name', '', [
            'placeholder' => 'Naam',
            'class' => 'form-control',
            ]) }}
        </div>

    @if($errors->first('surname'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::text('surname', '', [
            'placeholder' => 'Voornaam',
            'class' => 'form-control',
            ]) }}
        </div>

    @if($errors->first('age'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::text('age', '', [
            'placeholder' => 'Leeftijd',
            'class' => 'form-control',
            ]) }}
        </div>

    @if($errors->first('email'))
    <div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::email('email', '', [
        'placeholder' => 'E-mailadres',
        'class' => 'form-control',
        ]) }}
    </div>

    @if($errors->first('password'))
    <div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::betterPassword('password', '', [
        'placeholder' => 'Paswoord',
        'class' => 'form-control',
        ]) }}
    </div>

    <div class="form-group">
        {{ Form::submit('Bevestigen', [
        'class' => 'btn btn-lg btn-primary btn-block'
        ]) }}
    </div>
    {{ Form::close(), PHP_EOL }}

<!--    <p class="form-signin"> HTML::linkRoute('user.create', 'Registreren', [], ['class' => 'btn btn-default btn-block']) </p>-->
</div>

@stop