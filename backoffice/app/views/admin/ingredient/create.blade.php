@extends('layouts.admin.master')

@section('page-header')
<h1>
    Ingrediënten
    <small>
        Nieuw ingrediënt
    </small>
</h1>
@stop

@section('alerts')
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    Voeg een <strong>nieuw ingredient</strong> aan leftovers toe.
</div>
@stop

@section('content')
{{ Form::open(['route' => 'admin.ingredient.store', 'class' => 'form']), PHP_EOL }}

    @if(count($errors) != 0)
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    {{ Form::label('name', 'Naam'); }}
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

    {{ Form::label('description', 'Beschrijving'); }}
    @if($errors->first('description'))
    <div class="form-group has-error">
    @else
    <div class="form-group">
        @endif
        {{ Form::textarea('description', '', [
        'placeholder' => 'Beschrijving',
        'class' => 'form-control',
        'rows' => '5',
        ]) }}
    </div>

    {{ Form::label('calories', 'Calorieën (Kcal/100g)'); }}
    @if($errors->first('calories'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::text('calories', '', [
            'placeholder' => 'Calorieën',
            'class' => 'form-control',
            ]) }}
        </div>

    {{ Form::label('unit', 'Maateenheid'); }}
    <?php $unit = new Units(); ?>
    @if($errors->first('unit'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            <select name="unit" class="form-control">
                @foreach ($unit->units as $key => $unit)
                <option value="{{ $key }}">{{ $unit }}</option>
                @endforeach
            </select>
        </div>

    {{ Form::label('type', 'Soort'); }}
    <?php $types = new TypeIngredient(); ?>
    @if($errors->first('type'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            <select name="type" class="form-control">
                @foreach ($types->types as $key => $type)
                    <option value="{{ $key }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>


    <div class="form-group">
        {{ Form::submit('Toevoegen', [
        'class' => 'btn btn-lg btn-success'
        ]) }}
        <a class="btn btn-lg btn-primary" href="{{ route('admin.ingredient.index') }}">Terug naar overzicht</a>
    </div>

{{ Form::close(), PHP_EOL }}

@stop