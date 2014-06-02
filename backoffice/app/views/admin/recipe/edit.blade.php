@extends('layouts.admin.master')

@section('page-header')
<h1>
    Recepten
    <small>
        {{$recipe->name }}
    </small>
</h1>
@stop

@section('additional_styles')
{{ HTML::style('css/selectize/select2.css') }}
@stop

@section('content')
{{ Form::open(['route' => ['admin.recipe.update', $recipe->id], 'class' => 'form', 'method' => 'put', 'files' => true]), PHP_EOL }}

@if(count($errors) != 0 || Session::has('ingerror'))
<ul class="alert alert-danger">
    @if(Session::has('ingerror'))
    <li>{{Session::get('ingerror')}}</li>
    @endif
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
        {{ Form::text('name', $recipe->name, [
        'placeholder' => 'Naam',
        'class' => 'form-control',
        ]) }}
    </div>

    {{ Form::label('persons', 'Aantal Personen'); }}
    @if($errors->first('name'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::text('persons', $recipe->persons, [
            'placeholder' => 'Aantal personen',
            'class' => 'form-control',
            ]) }}
        </div>

    {{ Form::label('description', 'Beschrijving'); }}
    @if($errors->first('description'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            {{ Form::textarea('description', $recipe->description, [
            'placeholder' => 'Beschrijving',
            'class' => 'form-control',
            'rows' => '5',
            ]) }}
        </div>

        {{ Form::label('mainimage', 'Recept Afbeelding'); }}<br />
        <img src="{{ '../../../images/'. $recipe->image }}" >

        @if($errors->first('mainimage'))
        <div class="form-group has-error">
            @else
            <div class="form-group">
                @endif
                {{ Form::file('mainimage', '', [
                'class' => 'form-control',
                ]) }}
            </div>

    {{ Form::label('time', 'Bereidingstijd'); }}
    <?php $time = new Time(); ?>
    @if($errors->first('time'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            <select name="time" class="form-control">
                @foreach ($time->time as $key => $time)
                    @if($recipe->time == $time)
                    <option selected value="{{ $time }}">{{ $time }} minuten</option>
                    @elseif
                    <option value="{{ $time }}">{{ $time }} minuten</option>
                    @endif
                @endforeach
            </select>
        </div>

    {{ Form::label('level', 'Moeilijkheidsgraad'); }}
    <?php $level = new Level(); ?>
    @if($errors->first('level'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            <select name="level" class="form-control">
                @foreach ($level->level as $key => $level)
                    @if($recipe->level == $level)
                        <option selected value="{{ $level }}">{{ $level }}</option>
                    @elseif
                        <option value="{{ $level }}">{{ $level }}</option>
                    @endif
                @endforeach
            </select>
        </div>

    {{ Form::label('course', 'Gang'); }}
    <?php $course = new Course(); ?>
    @if($errors->first('course'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            <select name="course" class="form-control">
                @foreach ($course->course as $key => $course)
                    @if($recipe->course == $course)
                        <option selected value="{{ $course }}">{{ $course }}</option>
                    @elseif
                        <option value="{{ $course }}">{{ $course }}</option>
                    @endif
                @endforeach
            </select>
        </div>

    {{ Form::label('type', 'Soort'); }}
    <?php $types = new TypeRecipe(); ?>
    @if($errors->first('types'))
    <div class="form-group has-error">
        @else
        <div class="form-group">
            @endif
            <select name="type" class="form-control">
                @foreach ($types->types as $key => $type)
                    @if($recipe->type == $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @elseif
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endif
                @endforeach
            </select>
        </div>

    {{ Form::label('ingredients', 'Ingrediënten'); }}

    @if($errors->first('ingredients'))
    <div class="form-group has-error">
        @else
        <div id="ingredientAmount">
            <a href="#" class="btn btn-success btn-large add">Ingrediënt toevoegen</a>
        </div>
        <div id="ingredients" class="form-group">
            @endif
            <?php $count = 0; ?>
            @foreach ($recipe->ingredients as $recing)
            <a href="#" class="btn btn-danger btn-large removeIngredient"><i class="fa fa-trash-o"></i></a>
                <select name="ingredient[<?php echo $count; ?>]" data-placeholder="Selecteer een ingrediënt">
                    <option></option>
                    @foreach (Ingredient::all() as $ingredient)
                        @if($recing->name == $ingredient->name)
                            <option selected="selected" value="{{ $ingredient->id }}">{{ $ingredient->name . ' (' . $ingredient->unit .')' }}</option>
                        @else
                            <option value="{{ $ingredient->id }}">{{ $ingredient->name . ' (' . $ingredient->unit .')' }}</option>
                        @endif
                    @endforeach
                </select>
                <input name="amount[<?php echo $count; ?>]" value="{{ $recing->pivot->amount }}" class="form-control" />

                <?php $count = $count . 1; ?>
            @endforeach
        </div>



  <div class="form-group">
        {{ Form::submit('Aanpassen', [
        'class' => 'btn btn-lg btn-success'
        ]) }}
        <a class="btn btn-lg btn-primary" href="{{ route('admin.recipe.index') }}">Terug naar overzicht</a>
    </div>

{{ Form::close(), PHP_EOL }}

@stop

@section('additional_scripts')
{{ HTML::script("js/selectize/select2.min.js") }}
<script>
    $(document).ready(function(){
        CKEDITOR.replace('description');
    })

    var select = $('select[name="ingredient[0]"]').clone();
    $('#ingredients select').select2({
        placeholder: "Selecteer een ingrediënt"
    });
    var count = 0;

    $('#ingredientAmount a').click(function(event){
        event.preventDefault();
        count++;
        var newselect = select.clone();
        newselect.attr('name','ingredient['+count+']');

        $('#ingredients').append('<a href="#" class="btn btn-danger btn-large removeIngredient"><i class="fa fa-trash-o"></i></a>');
        $('#ingredients').append(newselect);
        $('#ingredients').append('<input name="amount['+count+']" placeholder="Hoeveelheid" class="form-control" />');
        $('select[name="ingredient['+count+']"]').select2();

        removeIngredient();
    });

    function removeIngredient(){
        $('.removeIngredient').click(function(event){
            event.preventDefault();
            $(this).next().remove();
            $(this).next().remove();
            $(this).next().remove();
            $(this).remove();
        });
    }

    removeIngredient();

</script>

@stop
