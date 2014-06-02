<ul class="nav">
    <!--DASHBOARD-->
    <li class="{{ Request::is('admin') ? 'active' : '' }}"><a href="{{ route('admin',[]) }}" data-toggle="tooltip" title="Dashboard"><i class="fa fa-dashboard fa-lg"></i></a>
    </li>

    <!--Ingredients-->
    <li class="{{ Request::is('admin/ingredient*') ? 'active' : '' }}"><a href="{{ route('admin.ingredient.index', []) }}" data-toggle="tooltip" title="Ingrediënten"><i class="fa fa-microphone fa-lg"></i></a>

    <!--Recipes-->
    <li class="{{ Request::is('admin/recipe*') ? 'active' : '' }}"><a href="{{ route('admin.recipe.index', []) }}" data-toggle="tooltip" title="Recepten"><i class="fa fa-bolt fa-lg"></i></a>
    </li>

    <!--USERS-->
    <li class="{{ Request::is('admin/user*') ? 'active' : '' }}"><a href="{{ route('admin.user.index',[]) }}" data-toggle="tooltip" title="Gebruikers"><i class="fa fa-users fa-lg"></i></a></li>
</ul>
