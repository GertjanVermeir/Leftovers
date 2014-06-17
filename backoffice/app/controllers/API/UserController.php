<?php

class API_UserController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = User::all();
        return Response::json($user)->setCallback(Input::get('jsonp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::json()->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'password_repeated' => 'required|same:password',
            'givenname' => 'required|min:2|max:45',
            'surname' => 'required|min:2|max:45',
            'birthday' => 'required',
            'picture' => 'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {
            $user = new User($input);
            $user->role = 'User';
            $user->chef = 0;
            $user->blacklist = false;

            $user->password = Input::json('password'); // Hash wordt in het model geregeld via het 'creating' event!
            $user->save();

            $user->load('recipes');
            $user->load('likes');
            $user->load('following');

            return Response::json($user); // Zie: $ php artisan routes

        } else {
            return Response::json('niet gelukt! :(');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $user->role = '';

        $user->load('Recipes');
        $user->load('followers');

        if (empty($user)) {
            return Redirect::route('api.user.index');
        } else {
            return Response::json($user)->setCallback(Input::get('jsonp'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::json()->all();

        $rules = [
            'givenname' => 'required|min:2|max:45',
            'surname' => 'required|min:2|max:45',
            'birthday' => 'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {
            $user = User::find($id);

            $user->givenname = $input['givenname'];
            $user->surname = $input['surname'];
            $user->birthday = $input['birthday'];

            $user->save();

            return Response::json('gelukt!'); // Zie: $ php artisan routes

        } else {
            return Response::json('niet gelukt! :(');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return Response::json("gelukt!")->setCallback(Input::get('jsonp'));;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function email()
    {
        $input = Input::json()->all();

        $searcheduser = "false";

        foreach (User::all() as $user) {
            if ($user->email == $input['email']) {
                $searcheduser = $user;
                break;
            }
        }

        if($searcheduser == "false"){
            return Response::json("Not Found");
        }
        else{
            return Response::json($searcheduser);
        }
    }

}