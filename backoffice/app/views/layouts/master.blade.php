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
    <title>@yield('title')</title>

    {{
    HTML::style("//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/{$version['twitter-bootstrap']}/css/bootstrap.min.css")
    }}

    @yield('additional_styles')
</head>
<body>
@yield('content')

{{ HTML::script("//cdnjs.cloudflare.com/ajax/libs/jquery/{$version['jquery']}/jquery.min.js") }}
{{
HTML::script("//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/{$version['twitter-bootstrap']}/js/bootstrap.min.js")
}}
@yield('additional_scripts')
</body>
</html>