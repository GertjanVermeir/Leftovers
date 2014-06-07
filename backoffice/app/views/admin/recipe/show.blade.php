@extends('layouts.admin.master')

@section('page-header')
<h1>
    Recept - {{ $recipe->name }}
    <small>
        Alle informatie
    </small>
</h1>
@stop

@section('content')
<table class="table">
    <tbody>
    <!--    NAME-->
    <tr>
        <th>Recept id</th>
        <td>{{ $recipe->id }}</td>
    </tr>

    <!--    AUTHOR-->
    <tr>
        <th>
            Auteur
        </th>
        <td>{{ $recipe->user->givenname . ' ' . $recipe->user->surname }}</td>
    </tr>

    <!-- DESCRIPTION -->
    <tr>
        <th>
            Beschrijving
        </th>
        <td><p>{{ $recipe->description }}</p></td>
    </tr>

    <!-- IMAGE -->
    <tr>
        <th>
            Image
        </th>
        <td><img class="platform-icon" src="{{ '../../images/recipes/'. $recipe->image }}" ></td>
    </tr>


    <!-- TIME -->
    <tr>
        <th>Bereidingstijd</th>
        <td>{{ $recipe->time }} minuten</td>
    </tr>

    <!-- LEVEL-->
    <tr>
        <th>Moeilijkheidsgraad</th>
        <td>
            {{ $recipe->level }}
        </td>
    </tr>
    <!-- COURSE-->
    <tr>
        <th>
            Gang
        </th>
        <td>
            {{ $recipe->course }}
        </td>
    </tr>
    <!--TYPE-->
    <tr>
        <th>Soort</th>
        <td>{{ $recipe->type }}</td>
    </tr>
    <!--INGREDIENTS-->
    <tr>
        <th>Ingrediënten</th>
        <td>
            @foreach($recipe->ingredients as $ingredient)
                <li>{{$ingredient->name}}</li>
            @endforeach
        </td>
    </tr>

    </tbody>
</table>

<a class="btn btn-lg btn-primary" href="{{ route('admin.recipe.index') }}">Terug naar overzicht</a>
<a class="btn btn-lg btn-success" href="{{ route('admin.recipe.edit', $recipe->id) }}">Aanpassen</a>
@stop