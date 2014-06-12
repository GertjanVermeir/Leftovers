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

                $comment->load('User');

                return Response::json($comment)->setCallback(Input::get('jsonp'));
            }
            elseif($input['action'] == 'delete')
            {
                $comment = Comment::findOrFail($input['id']);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $recipe_id
     * @return Response
     */
    public function show($recipe_id)
    {
        $comments = Comment::where('recipe_id' , '=', $recipe_id)->get();
        $comments->load('User');

        if (empty($comments)) {
            return Response::json('Geen comments.')->setCallback(Input::get('jsonp'));
        }

        return Response::json($comments)->setCallback(Input::get('jsonp'));

    }
} 