<?php

class API_ArtistController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $artists = Artist::all();

        foreach ($artists as $artist) {
            $artist->load('Timeslot');
        }

        return Response::json($artists)->setCallback(Input::get('jsonp'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $artist_id
     * @return Response
     */
    public function show($artist_id)
    {
        $artist = Artist::find($artist_id);

        if (empty($artist)) {
            return Redirect::route('api.artist.index');
        } else {

            $artist->load('Timeslot');

            return Response::json($artist)->setCallback(Input::get('jsonp'));
        }

        /*$artist->load('Timeslot');

        return Response::json($artist)->setCallback(Input::get('jsonp'));*/
    }

} 