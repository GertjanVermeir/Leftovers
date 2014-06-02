@extends('layouts.admin.master')

@section('page-header')
<h1>
    Dashboard
    <small>
        Organize the Leftovers stuff!
    </small>
</h1>
@stop

@section('content')

<div class="row">
    <a href="{{ route('admin.ingredient.index') }}" title="Ingrediënten Management">
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><i class="fa fa-microphone"></i>&nbsp;&nbsp;&nbsp;{{ Ingredient::count() }}
                        <small>Ingrediënten</small>
                    </h2>
                </div>
            </div>
        </div>
    </a>
</div>

@stop