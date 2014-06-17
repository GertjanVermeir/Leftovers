<?php

class API_EditController extends \BaseController
{

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function updateUser()
    {
        $input = Input::json()->all();

        $rules = [
            'givenname' => 'required|min:2|max:45',
            'surname' => 'required|min:2|max:45',
            'birthday' => 'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {
            $user = User::find($input['id']);

            $user->givenname = $input['givenname'];
            $user->surname = $input['surname'];
            $user->birthday = $input['birthday'];

            if($input['picture'] != $user->picture)
            {
                File::delete(public_path().'/images/users/'.$user->picture);
                $user->picture = $input['picture'];
            }

            $user->save();

            $user->load('recipes');
            $user->load('likes');
            $user->likes->load('recipe');
            $user->load('following');

            return Response::json($user)->setCallback(Input::get('jsonp'));

        } else {
            return Response::json("niet gelukt!")->setCallback(Input::get('jsonp'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function updateRecipe()
    {
        $ingredientCheck = true;
        $amountCheck = true;

        $input = Input::json()->all();

        $amounts = $input['amount'];
        $ingredients = $input['ingredient'];

        $rules = [
            'name' => 'required',
            'description' => 'required',
            'time' => 'required',
            'level' => 'required',
            'course' => 'required',
            'type' => 'required',
            'ingredient' => 'required|array',
            'amount' => 'required|array',
            'persons' => 'required|integer',
            'user_id' => 'required',
        ];

        foreach($ingredients as $ingredient)
        {
            if($ingredient == '')
            {
                $ingredientCheck = false;
            }
        }

        foreach($amounts as $amount)
        {
            if($amount == '')
            {
                $amountCheck = false;
            }
        }

        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {

            $recipe = Recipe::find($input['id']);

            if($amountCheck == false || $ingredientCheck == false)
            {
                return Response::json('Vul de lege ingredienten in.');
            }

            $recipe->name = $input['name'];
            $recipe->description = $input['description'];
            $recipe->time = $input['time'];
            $recipe->level = $input['level'];
            $recipe->course = $input['course'];
            $recipe->type = $input['type'];
            $recipe->persons = $input['persons'];

            if(isset($input['mainimage']))
            {
                File::delete(public_path().'/images/recipes/'.$recipe->image);
                $recipe->image = $input['mainimage'];
            }

            $recipe->ingredients()->detach();

            $recipe->save();

            foreach($ingredients as $key => $ingredient)
            {
                $id = Ingredient::where('name' , '=', $ingredient)->first();

                $amount = $amounts[$key];
                $recipe->ingredients()->attach($id,array('amount' => $amount ));
            }

            return Response::json($recipe)->setCallback(Input::get('jsonp'));

        } else {
            return Response::json('Foutieve ingave.')->setCallback(Input::get('jsonp'));
        }


    }

}