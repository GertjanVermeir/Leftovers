@extends('layouts.admin.master')

@section('page-header')
<h1>
    User Management
    <small>
        Nieuwe gebruiker
    </small>
</h1>
@stop

@section('alerts')
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    Voeg een nieuwe <strong>gebruiker</strong> aan Leftovers toe.
</div>
@stop

@section('content')
{{ Form::open(['route' => 'admin.user.store', 'class' => 'form', 'files' => true]), PHP_EOL }}

@if(count($errors) != 0)
<ul class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

{{ Form::label('email', 'E-mailadres'); }}
@if($errors->first('email'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::email('email', '', [
        'placeholder' => 'name@client.be',
        'class' => 'form-control',
        ]) }}
    </div>

{{ Form::label('givenname', 'Voornaam'); }}
@if($errors->first('givenname'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::text('givenname', '', [
        'placeholder' => 'Voornaam',
        'class' => 'form-control',
        ]) }}
    </div>

{{ Form::label('surname', 'Achternaam'); }}
@if($errors->first('surname'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::text('surname', '', [
        'placeholder' => 'Achternaam',
        'class' => 'form-control',
        ]) }}
    </div>

@if($errors->first('birthday'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::date('birthday', '', [
        'class' => 'form-control',
        ]) }}
    </div>

{{ Form::label('role', 'Gebruikersrechten'); }}
@if($errors->first('role'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        <select name="role" class="form-control">
            <option value="Administrator">Administrator</option>
            <option value="User">Gebruiker</option>
        </select>
    </div>

{{ Form::label('password', 'Paswoord'); }}
@if($errors->first('password'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::betterPassword('password', '', [
        'placeholder' => 'Password',
        'class' => 'form-control',
        ]) }}
    </div>

    @if($errors->first('password_repeated'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::betterPassword('password_repeated', '', [
            'placeholder' => 'Repeat your password',
            'class' => 'form-control',
            ]) }}
        </div>

    {{ Form::label('picture', 'Profielfoto'); }}
    @if($errors->first('picture'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::file('picture', '', [
            'class' => 'form-control',
            ]) }}
        </div>

{{ Form::label('chef', 'Chefkok'); }}
@if($errors->first('blacklist'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::checkbox('chef', '', [
        ]) }}

        Is chefkok
    </div>

{{ Form::label('blacklist', 'Blacklist'); }}
@if($errors->first('blacklist'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::checkbox('blacklist', '', [
        ]) }}

        Toevoegen aan de blacklist
    </div>

    <div class="form-group">
        {{ Form::submit('Toevoegen', [
        'class' => 'btn btn-lg btn-success'
        ]) }}
        <a class="btn btn-lg btn-primary" href="{{ route('admin.user.index') }}">Terug naar overzicht</a>
    </div>

{{ Form::close(), PHP_EOL }}

@stop