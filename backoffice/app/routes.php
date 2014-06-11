<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * -------------------------------------
 * ACCESSIBLE FOR EVERYONE !
 * -------------------------------------
 */
Route::get('/', [
    'as' => 'UberIndex',
    function () {
        return View::make('hello');
    }
]);

/**
 * API
 */
Route::group(['prefix' => 'api'], function () {
    Route::resource('recipe', 'API_RecipeController', [
        'except' => [

        ]
    ]);

    Route::resource('image', 'API_ImageController', [
        'except' => [

        ]
    ]);

    Route::resource('like', 'API_LikeController', [
        'except' => [

        ]
    ]);

    Route::resource('comment', 'API_CommentController', [
        'except' => [

        ]
    ]);

    Route::resource('recipes', 'API_RecipesController', [
        'except' => [

        ]
    ]);

    Route::resource('ingredient', 'API_IngredientController', [
        'except' => [

        ]
    ]);

    Route::resource('user', 'API_UserController', [
        'except' => [
            'create',
            'edit',
        ]
    ]);

    Route::get('checkuser/{email}',
        ['as' => 'api.checkuser', function ($email) {
            $exists = false;
            foreach (User::all() as $user) {
                if ($user->email == $email) {
                    $exists = true;
                    return Response::json($exists);
                }
            }
            return Response::json($exists);
        }]);

    Route::post('login',
        ['as' => 'api.login',
            function () {
                $input = Input::json()->all();

                $creds = [
                    'email' => $input["email"],
                    'password' => $input["password"],
                ];

                if (Auth::attempt($creds)) {
                    $user = Auth::user();

                    $user->load('recipes');
                    $user->load('likes');


                    Auth::logout();

                    return Response::json($user);
                }

                return Response::json("mislukt");
            }
        ]);
});


/**
 * -------------------------------------
 * ACCESSIBLE FOR GUESTS (NOT LOGGED IN)
 * -------------------------------------
 */
Route::group(['before' => 'guest'], function () {

    /**
     * Guests should be able to login
     */
    Route::get('/login', [
        'as' => 'user.login',
        function () {
            return View::make('login');
        }
    ]);

    Route::get('/register', [
        'as' => 'user.register',
        function () {
            return View::make('register');
        }
    ]);

    Route::post('/login', [
        'as' => 'user.auth',
        'uses' => 'UserController@auth'
    ]);
});


/**
 * -------------------------------------
 * ACCESSIBLE FOR AUTH (LOGGED IN)
 * -------------------------------------
 */
Route::group(['before' => 'auth'], function () {
    /**
     * LOGOUT
     */
    Route::get('/logout', [
        'as' => 'user.logout',
        function () {
            Auth::logout();

            return Redirect::route('UberIndex');
        }
    ]);


    /**
     * ADMIN
     * -------------
     * For Administrators!
     */
    Route::group(['before' => 'admin'], function () {
        Route::get('admin', [
            'as' => 'admin',
            function () {
                return View::make('admin.index');
            }
        ]);

        Route::resource('admin/role', 'Admin_RoleController',
            ['except' => ['show']]);

        Route::resource('admin/ingredient', 'Admin_IngredientController');
        Route::resource('admin/recipe', 'Admin_ReceptController');

        Route::resource('admin/user', 'UserController');

    });
});
