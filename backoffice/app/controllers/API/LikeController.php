<?php

class API_LikeController extends \BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::json()->all();

        if(isset($input['action']) && $input['user_id'] && $input['recipe_id'])
        {
            if($input['action'] == 'like')
            {
                $like = new Like();
                $like->user_id = $input['user_id'];
                $like->recipe_id = $input['recipe_id'];
                $like->timestamps = '';
                $like->save();

                return Response::json('Liked')->setCallback(Input::get('jsonp'));
            }
            elseif($input['action'] == 'unlike')
            {
                $like = Like::where('user_id' , '=', $input['user_id'])->where('recipe_id' , '=', $input['recipe_id'])->first();

                $like->delete();

                return Response::json('Unliked')->setCallback(Input::get('jsonp'));
            }
            else{
                return Response::json('Action unknown')->setCallback(Input::get('jsonp'));
            }
        }
        else{
            return Response::json('Params missing')->setCallback(Input::get('jsonp'));
        }
    }
} 