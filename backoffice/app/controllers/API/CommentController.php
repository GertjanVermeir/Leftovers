<?php

class API_CommentController extends \BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::json()->all();

        if(isset($input['action']) && $input['user_id'] && $input['recipe_id'] && $input['description'])
        {
            if($input['action'] == 'add')
            {
                $comment = new Comment();
                $comment->user_id = $input['user_id'];
                $comment->recipe_id = $input['recipe_id'];
                $comment->description = $input['description'];
                $comment->save();

                return Response::json('Added')->setCallback(Input::get('jsonp'));
            }
            elseif($input['action'] == 'delete')
            {
                $comment = Comment::where('user_id' , '=', $input['user_id'])->where('recipe_id' , '=', $input['recipe_id'])->where('description' , '=', $input['description'])->first();

                $comment->delete();

                return Response::json('Deleted')->setCallback(Input::get('jsonp'));
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