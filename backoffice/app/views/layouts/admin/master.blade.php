<?php
$version = [
    'twitter-bootstrap' => '3.0.0-rc2',
    'jquery' => '2.0.3',
];
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Festivaluta[ADMIN]</title>

    {{
    HTML::style("//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/{$version['twitter-bootstrap']}/css/bootstrap.min.css")
    }}

    {{
    HTML::style('css/admin.css')
    }}
    {{
    HTML::style('css/font-awesome.css')
    }}

    {{  HTML::script('js/ckeditor/ckeditor.js') }}

    @yield('additional_styles')
</head>
<body>
@include('layouts.admin.header')
<div class="container">
    <div id="sidebar" class="col-xs-12 col-sm-1 col-md-1 col-lg-1 collapse">
        @include('layouts.admin.navigation')
    </div>
    <div id="main" class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
        <div class="content">
            <div class="page-header">
                @yield('page-header')
            </div>
            @yield('alerts')
            @yield('content')
        </div>
    </div>
</div>
</body>
{{ HTML::script("//cdnjs.cloudflare.com/ajax/libs/jquery/{$version['jquery']}/jquery.min.js") }}
{{
HTML::script("//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/{$version['twitter-bootstrap']}/js/bootstrap.min.js")
}}
{{
HTML::script("js/dashboard.js")
}}

@yield('additional_scripts')
</body>
</html>