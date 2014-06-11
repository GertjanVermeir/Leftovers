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
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {
            $user = new User($input);
            $user->role = 2;

            $user->password = Input::json('password'); // Hash wordt in het model geregeld via het 'creating' event!
            $user->save();

            return Response::json('gelukt!'); // Zie: $ php artisan routes

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

        return Response::json("gelukt!");
    }

}