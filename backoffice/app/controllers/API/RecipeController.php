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
     * @param  int  $artist_id
     * @return Response Redirect
     */
    public function show($recipe_id)
    {
        $recipe = Recipe::find($recipe_id);
        $recipe->load('ingredients');

        $steps = $recipe->description;
        $steps = str_replace("<p>","", $steps);
        $steps = explode("</p>", $steps);

        array_pop($steps);

        $recipe->description = $steps;

        if (empty($recipe)) {
            return Response::json('Recept niet gevonden.')->setCallback(Input::get('jsonp'));
        }

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
            'mainimage' => 'required|image',
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
                return Response::json('Foutieve ingave.');
            }

            $recipe = new Recipe([
                'name' => $input['name'],
                'description' => $input['description'],
                'time' => $input['time'],
                'level' => $input['level'],
                'course' => $input['course'],
                'type' => $input['type'],
                'persons' => $input['persons'],
                'mainimage' => $input['mainimage'],
                'user_id' => $input['user_id'],
            ]);

            if (Input::hasFile('mainimage')) {
                $file            = Input::file('mainimage');
                $root            = public_path();
                $destinationPath = $root.'/images/users/';
                $filename        = str_random(6) . '_' . $file->getClientOriginalName();
                $uploadSuccess   = $file->move($destinationPath, $filename);
                $recipe->image = $filename;
            }

            $recipe->save();

            foreach($ingredients as $key => $ingredient)
            {
                $amount = $amounts[$key];
                $recipe->ingredients()->attach($ingredient,array('amount' => $amount ));
            }

            return Response::json('Je recept werd toegevoegd.');

        } else {
            return Response::json('Foutieve ingave.');
        }


    }

} 