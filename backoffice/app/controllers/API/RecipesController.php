<?php

class API_RecipesController extends \BaseController
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
     * @param  int  $user_id
     * @return Response
     */
    public function show($user_id)
    {
        $recipes = Recipe::where('user_id' , '=', $user_id);

        if (empty($recipes)) {
            return Response::json('Geen recepten gevonden.')->setCallback(Input::get('jsonp'));
        }

        return Response::json($recipes)->setCallback(Input::get('jsonp'));

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

            if (Input::hasFile('mainimage')) {
                $file            = Input::file('mainimage');
                $root            = public_path();
                $destinationPath = $root.'/images/recipes/';
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

            return Response::json('Je recept werd toegevoegd.')->setCallback(Input::get('jsonp'));;

        } else {
            return Response::json('Foutieve ingave.')->setCallback(Input::get('jsonp'));;
        }
    }

    public function recipeByName($name){

    }

} 