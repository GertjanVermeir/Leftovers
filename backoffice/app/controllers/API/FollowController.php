<?php

class API_FollowController extends \BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::json()->all();

        if(isset($input['action']) && $input['user_id'] && $input['follow_id'])
        {
            if($input['action'] == 'follow')
            {
                $follow = new Follow();
                $follow->user_id = $input['user_id'];
                $follow->follow_id = $input['follow_id'];
                $follow->timestamps = '';
                $follow->save();

                $user = User::where('id' , '=', $input['follow_id'])->first();
                $user = $user->toArray();

                $follow->user = $user;

                return Response::json($follow)->setCallback(Input::get('jsonp'));
            }
            elseif($input['action'] == 'unfollow')
            {
                $like = Follow::where('user_id' , '=', $input['user_id'])->where('follow_id' , '=', $input['follow_id'])->first();

                $like->delete();

                return Response::json('Unfollow')->setCallback(Input::get('jsonp'));
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