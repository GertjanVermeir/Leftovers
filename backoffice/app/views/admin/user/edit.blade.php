@extends('layouts.admin.master')

@section('page-header')
<h1>
    User Management
    <small>
        {{ $user->givenname }}
    </small>
</h1>
@stop

@section('content')
{{ Form::open(['route' => ['admin.user.update', $user->id], 'class' => 'form', 'method' => 'put', 'files' => true]), PHP_EOL }}

@if(count($errors) != 0)
<ul class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

{{ Form::label('givenname', 'Voornaam'); }}
@if($errors->first('givenname'))
<div class="form-group has-error">
@else
<div class="form-group">
    @endif
    {{ Form::text('givenname', $user->givenname, [
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
    {{ Form::text('surname', $user->surname, [
    'placeholder' => 'Achternaam',
    'class' => 'form-control',
    ]) }}
</div>

@if($errors->first('birthday'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::date('birthday', $user->birthday, [
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



{{ Form::label('picture', 'Profielfoto'); }}
    <img src="{{ '../../../images/users/'. $user->picture }}" >

@if($errors->first('picture'))
<div class="form-group has-error">
@else
<div class="form-group">
    @endif
    {{ Form::file('picture', '', [
    'class' => 'form-control',
    ]) }}
</div>

{{ Form::label('blacklist', 'Blacklist'); }}
@if($errors->first('blacklist'))
<div class="form-group has-error">
@else
<div class="form-group">
    @endif
    {{ Form::checkbox('blacklist', $user->blacklist, [
    'placeholder' => 'blacklist',
    'class' => 'form-control',
    ]) }}

    Toevoegen aan de blacklist
</div>

{{ Form::label('chef', 'Chefkok'); }}
@if($errors->first('blacklist'))
<div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::checkbox('chef', $user->chef, [
        'placeholder' => 'blacklist',
        'class' => 'form-control',
        ]) }}

        Is chefkok
    </div>

<div class="form-group">
    {{ Form::submit('Aanpassen', [
    'class' => 'btn btn-lg btn-success'
    ]) }}
    <a class="btn btn-lg btn-success" href="{{ route('admin.user.show', $user->id) }}">Go back to overview</a>
</div>

{{ Form::close(), PHP_EOL }}

@stop