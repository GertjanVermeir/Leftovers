<?php

class API_UserController extends \BaseController
{

//    /**
//     * Display a listing of the resource.
//     *
//     * @return Response
//     */
//    public function index()
//    {
//        $recipes = User::all();
//
//        return Response::json($recipes)->setCallback(Input::get('jsonp'));
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $artist_id
     * @return Response Redirect
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        $user->load('recipes');

        if (empty($user)) {
            return Response::json('Gebruiker niet gevonden.')->setCallback(Input::get('jsonp'));
        }

        return Response::json($user)->setCallback(Input::get('jsonp'));

    }

} 