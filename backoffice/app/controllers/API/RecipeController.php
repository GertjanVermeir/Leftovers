<?php

class API_RecipeController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $recipes = Recipe::all();

        return Response::json($recipes)->setCallback(Input::get('jsonp'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $recipe_id
     * @return Response
     */
    public function show($recipe_id)
    {
        $ratingTotal = 0;

        $recipe = Recipe::find($recipe_id);

        if (empty($recipe)) {
            return Response::json('Recept niet gevonden.')->setCallback(Input::get('jsonp'));
        }

        $recipe->load('Ingredients');
        $recipe->load('Ratings');
        $recipe->load('Likes');

        $recipe->likeTotal = count($recipe->likes);

        foreach($recipe->ratings as $rating)
        {
            $ratingTotal +=  $rating->rating;
        }

        if(count($recipe->ratings) > 0)
        {
            $recipe->ratingTotal = $ratingTotal/count($recipe->ratings);
            $recipe->ratingTotal = floor($recipe->ratingTotal * 2) / 2;
        }
        else{
            $recipe->ratingTotal = 0;
        }


        $steps = $recipe->description;
        $steps = str_replace("<p>","", $steps);
        $steps = explode("</p>", $steps);

        array_pop($steps);

        $recipe->description = $steps;


        $recipe->load('User');


        return Response::json($recipe)->setCallback(Input::get('jsonp'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $ingredientCheck = true;
        $amountCheck = true;

        $input = Input::json()->all();

        $amounts = $input['amount'];
        $ingredients = $input['ingredient'];

        $rules = [
            'name' => 'required|min:2|max:45',
            'description' => 'required',
            'time' => 'required',
            'level' => 'required',
            'course' => 'required',
            'type' => 'required',
            'ingredient' => 'required|array',
            'amount' => 'required|array',
            'persons' => 'required|integer',
            'mainimage' => 'required',
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

            if($amountCheck == false || $ingredientCheck == false)
            {
                return Response::json('Vul de lege ingredienten in.');
            }

            $recipe = new Recipe([
                'name' => $input['name'],
                'description' => $input['description'],
                'time' => $input['time'],
                'level' => $input['level'],
                'course' => $input['course'],
                'type' => $input['type'],
                'persons' => $input['persons'],
                'image' => $input['mainimage'],
                'user_id' => $input['user_id'],
            ]);

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


    public function leftovers(){
        $input = Input::json()->all();

        $ingArray = [];
        $foundRecipes = array();

        $recipes = Recipe::all();
        $recipes->load('ingredients');

        foreach ($recipes as $recipe) {

            $ingArray = [];

            foreach ($recipe->ingredients as $ingredient)
            {
                array_push($ingArray,$ingredient->name);
            }

            $result = array_intersect($ingArray, $input);

            if(count($result) == count($input))
            {
                $recipe->match = 'perfect';
                array_unshift($foundRecipes,$recipe->toArray());
            }
            else if(count($result) >= (count($input)/2 )){
                $recipe->match = count($result);
                $foundRecipes[] = $recipe->toArray();
            }
        }

        array_slice($foundRecipes, 0, 9);

        return Response::json($foundRecipes)->setCallback(Input::get('jsonp'));
    }

} 