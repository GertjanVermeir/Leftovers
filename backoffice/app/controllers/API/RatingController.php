<?php

class API_RatingController extends \BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::json()->all();

        $rating = '';

        $rating = Rating::where('user_id' , '=', $input['user_id'])->where('recipe_id' , '=', $input['recipe_id'])->first();

        if($input['rating'] == "get")
        {
            //Do nothing;
        }
        else if($rating && $input['rating'] == 0)
        {
            $rating->delete();

            return Response::json('Deleted')->setCallback(Input::get('jsonp'));
        }
        else if($rating){
            $rating->recipe_id = $input['recipe_id'];
            $rating->user_id = $input['user_id'];
            $rating->rating = $input['rating'];
            $rating->timestamps = '';
            $rating->save();
        }else if($input['rating'] != 0){
            $rating = new Rating();
            $rating->recipe_id = $input['recipe_id'];
            $rating->user_id = $input['user_id'];
            $rating->rating = $input['rating'];
            $rating->timestamps = '';
            $rating->save();
        }else{
            $rating = false;
        }

        return Response::json($rating)->setCallback(Input::get('jsonp'));
    }
} 