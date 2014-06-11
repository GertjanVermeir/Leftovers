<?php

class API_ImageController extends \BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if(Input::hasFile('file')){
            $file = Input::file('file');

            $root            = public_path();
            $destinationPath = $root.'/images/recipes/';
            $filename = str_random(6) . '_' . $file->getClientOriginalName();
            $upload_success = Input::file('file')->move($destinationPath, $filename);

            if($upload_success){
                return Response::json($filename)->setCallback(Input::get('jsonp'));
            }
            else{
                return Response::json('Afbeelding uploaden is mislukt.')->setCallback(Input::get('jsonp'));
            }
        }else{
            return Response::json('Geen afbeelding gevonden.')->setCallback(Input::get('jsonp'));
        }
    }
} 