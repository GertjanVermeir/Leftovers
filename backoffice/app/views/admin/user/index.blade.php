@extends('layouts.admin.master')

@section('page-header')
<h1>
    Gebruikers
    <small>
        Beheer van alle gebruikers
    </small>
</h1>
@stop

@section('alerts')
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Overzicht van alle gebruikers</strong>.
</div>
@stop

@section('content')
@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif

@if(User::count() == 0)
    <div>
        <h3 class="text-center"><i class="fa fa-frown-o fa-5x"></i><br>There are no users.</h3>
    </div>
@else
    <table class="table table-hover">
        <thead>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach (User::all() as $user)
            <tr>
                <td><a title="Edit user" href="{{ route('admin.user.show', $user->id) }}">{{ $user->givenname }}</a></td>
                <td>{{ $user->surname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <!--            SHOW -->
                    <a href="{{ route('admin.user.show', $user->id) }}">
                        <i class="fa fa-search"></i>
                    </a>
                    <!--            EDIT ROLE -->
                    <a title="Edit user" href="{{ route('admin.user.edit', $user->id) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    {{ Form::open(['route' => ['admin.user.destroy', $user->id], 'method' => 'delete', 'id' => 'deleteform-' . $user->id ]) }}
                        <a href="#" onclick="document.getElementById('deleteform-{{ $user->id }}').submit()"><i class="fa fa-trash-o"></i></a>
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif


<a class="btn btn-lg btn-primary" href="{{ route('admin.user.create') }}">New user</a>
@stop