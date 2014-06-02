<div class="navbar">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#sidebar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('admin') }}">Leftovers [ADMIN]</a>
        </div>
        <div class="navbar-right">
            <a href="{{ route('user.logout') }}" class="navbar-courtesy">Hi, {{ucfirst(Auth::user()->givenname) }}! Logout</a>
        </div>
    </div>
</div>