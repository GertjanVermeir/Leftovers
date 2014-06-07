@extends('layouts.admin.master')

@section('page-header')
<h1>
    Recepten
    <small>
        Lijst van alle recepten.
    </small>
</h1>
@stop

@section('alerts')
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    Voeg zo veel mogelijk <strong>nieuwe recepten</strong> toe.
</div>
@stop

@section('content')
@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif

@if(Recipe::count() == 0)
<div>
    <h3 class="text-center"><i class="fa fa-frown-o fa-5x"></i><br>Geen recepten gevonden.</h3>
</div>
@else
<table class="table table-hover">
    <thead>
    <th>Naam</th>
    <th>Bereidingstijd</th>
    <th>Moeilijkheidsgraad</th>
    <th>Gang</th>
    <th>Ingrediënten</th>
    <th>Soort</th>
    <th>Acties</th>
    </thead>
    <tbody>

    <?php $levels = new Level(); $levels = $levels->level ?>
    <?php $course = new Course(); $course = $course->course ?>

    @foreach (Recipe::all() as $recipe)
    <tr>
        <td>
            <a href="{{ route('admin.recipe.show', $recipe->id) }}">
                {{ $recipe->name }}
            </a>
        </td>
        <td>{{ $recipe->time }}</td>
        <td>{{ $recipe->level }}</td>
        <td>{{ $recipe->course }}</td>
        <td><span class="badge">{{ Count($recipe->ingredients) }}</span></td>
        <td>{{ $recipe->type }}</td>
        <td>
            @if (Auth::user()->id == $recipe->user->id || Auth::user()->role == 'Administrator')
            <!--            SHOW -->
            <a href="{{ route('admin.recipe.show', $recipe->id) }}">
                <i class="fa fa-search"></i>
            </a>
<!--            EDIT -->
            <a href="{{ route('admin.recipe.edit', $recipe->id) }}">
                <i class="fa fa-edit"></i>
            </a>

<!--            DELETE -->
            {{ Form::open(['route' => ['admin.recipe.destroy', $recipe->id], 'method' => 'delete', 'id' => 'deleteform-' . $recipe->id ]) }}
            <a href="#" onClick="if (confirm('Zeker dat je dit recept wilt verwijderen?')){
            document.getElementById('deleteform-{{ $recipe->id }}').submit();
            }"><i class="fa fa-trash-o"></i></a>
            {{ Form::close() }}

            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif


<a class="btn btn-lg btn-primary" href="{{ route('admin.recipe.create') }}">Nieuw recept</a>
@stop