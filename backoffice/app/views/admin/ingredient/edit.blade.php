@extends('layouts.admin.master')

@section('page-header')
<h1>
    Ingrediënten
    <small>
        {{$ingredient->name }}
    </small>
</h1>
@stop

@section('content')
{{ Form::open(['route' => ['admin.ingredient.update', $ingredient->id], 'class' => 'form', 'method' => 'put']), PHP_EOL }}

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
        {{ Form::text('name', $ingredient->name, [
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
            {{ Form::textarea('description', $ingredient->description, [
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
                {{ Form::text('calories', $ingredient->calories, [
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
                            @if($ingredient->unit == $key)
                                <option selected value="{{ $key }}">{{ $unit }}</option>
                            @else
                                <option value="{{ $key }}">{{ $unit }}</option>
                            @endif
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
                                @if($ingredient->type == $key)
                                <option selected value="{{ $key }}">{{ $type }}</option>
                                @else
                                <option value="{{ $key }}">{{ $type }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>




                    <div class="form-group">
        {{ Form::submit('Aanpassen', [
        'class' => 'btn btn-lg btn-success'
        ]) }}
        <a class="btn btn-lg btn-primary" href="{{ route('admin.ingredient.index') }}">Terug naar overzicht</a>
    </div>

{{ Form::close(), PHP_EOL }}

@stop