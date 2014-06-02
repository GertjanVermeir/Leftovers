@extends('layouts.admin.master')

@section('page-header')
<h1>
    Ingrediënten
    <small>
        Lijst van beschikbare ingrediënten
    </small>
</h1>
@stop

@section('alerts')
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    Voeg zo veel mogelijk <strong>nieuwe ingrediënten</strong> toe.
</div>
@stop

@section('content')
@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif

@if(Ingredient::count() == 0)
<div>
    <h3 class="text-center"><i class="fa fa-frown-o fa-5x"></i><br>Geen ingrediënten gevonden.</h3>
</div>
@else
<table class="table table-hover">
    <thead>
    <th>Naam</th>
    <th>Soort</th>
    <th>Maateenheid</th>
    <th>Calorieën</th>
    <th>Acties</th>
    </thead>
    <tbody>

    <?php $types = new TypeIngredient(); $types = $types->types ?>
    <?php $units = new Units(); $units = $units->units ?>

    @foreach (Ingredient::all() as $ingredient)
    <tr>
        <td>{{ $ingredient->name }} </td>
        <td>{{ $types[$ingredient->type] }}</td>
        <td>{{ $units[$ingredient->unit] }}</td>
        <td>{{ $ingredient->calories }}</td>
        <td>
            @if (Auth::user()->role == 'Administrator')
<!--            EDIT -->
            <a href="{{ route('admin.ingredient.edit', $ingredient->id) }}">
                <i class="fa fa-edit"></i>
            </a>

<!--            DELETE -->
            {{ Form::open(['route' => ['admin.ingredient.destroy', $ingredient->id], 'method' => 'delete', 'id' => 'deleteform-' . $ingredient->id ]) }}
            <a href="#" onClick="if (confirm('Zeker dat je dit ingrediënt wilt verwijderen?')){
            document.getElementById('deleteform-{{ $ingredient->id }}').submit();
            }"><i class="fa fa-trash-o"></i></a>
            {{ Form::close() }}
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif


<a class="btn btn-lg btn-primary" href="{{ route('admin.ingredient.create') }}">Nieuw ingredient</a>
@stop