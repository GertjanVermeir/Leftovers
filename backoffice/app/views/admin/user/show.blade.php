@extends('layouts.admin.master')
@extends('layouts.admin.master')

@section('page-header')
<h1>
    {{ $user->email }}
    <small>
        All information
    </small>
</h1>
@stop

@section('content')
<img src="{{ '../../images/users/'. $user->picture }}" style="width: 200px;float: left" >
<table class="table">
    <tbody>
    <!--    NAME-->
    <tr>
        <td>ID</td>
        <td>{{ $user->id }}</td>
    </tr>
    <tr>
        <td>E-mailadres</td>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <td>Voornaam</td>
        <td>{{ $user->givenname }}</td>
    </tr>
    <tr>
        <td>Naam</td>
        <td>{{ $user->surname }}</td>
    </tr>
    <tr>
        <td>Geboortedatum</td>
        <td>{{ $user->birthday }}</td>
    </tr>
    <tr>
        <td>Role</td>
        <td>{{ $user->role }}</td>
    </tr>
    </tbody>
</table>

<div class="row">
    <a href="{{ route('admin.user.index') }}" title="Recepten">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><i class="fa fa-microphone"></i>&nbsp;&nbsp;&nbsp;{{ count($user->recipes()) }}
                        <small>Recepten</small>
                    </h2>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.user.index') }}" title="Recepten">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><i class="fa fa-microphone"></i>&nbsp;&nbsp;&nbsp;{{ Recipe::count() }}
                        <small>Reacties</small>
                    </h2>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.user.index') }}" title="Recepten">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><i class="fa fa-microphone"></i>&nbsp;&nbsp;&nbsp;{{ Recipe::count() }}
                        <small>Kookboeken</small>
                    </h2>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.user.index') }}" title="Recepten">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><i class="fa fa-microphone"></i>&nbsp;&nbsp;&nbsp;{{ Recipe::count() }}
                        <small>Volgers</small>
                    </h2>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="row">
    <a href="{{ route('admin.user.index') }}" title="Recepten">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><i class="fa fa-microphone"></i>&nbsp;&nbsp;&nbsp;{{ Recipe::count() }}
                        <small>Zoekopdrachten</small>
                    </h2>
                </div>
            </div>
        </div>
    </a>
</div>

<a class="btn btn-lg btn-primary" href="{{ route('admin.user.index') }}">Zoek andere gebruiker</a>
<a class="btn btn-lg btn-success" href="{{ route('admin.user.edit', $user->id) }}">Aanpassen</a>
@stop