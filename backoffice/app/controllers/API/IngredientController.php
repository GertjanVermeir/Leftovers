<?php

class API_IngredientController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $ingredients = Ingredient::all();

        return Response::json($ingredients)->setCallback(Input::get('jsonp'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $ingredient_id
     * @return Response
     */
    public function show($ingredient_id)
    {
        $ingredient = Ingredient::find($ingredient_id);

        if (empty($ingredient)) {
            return Response::json('Ingredient niet gevonden.')->setCallback(Input::get('jsonp'));
        }

        return Response::json($ingredient)->setCallback(Input::get('jsonp'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::json()->all();

        $rules = [
            'name' => 'required|min:2|max:45',
            'description' => 'required',
            'calories' => 'required',
            'unit' => 'required',
            'type' => 'required',
        ];

        $messages = [
            'required' => 'Vul :attribute in.',
            'min' => ':attribute is te kort short. Een minimum van 2 karakters is verplicht.',
            'max' => ':attribute is te lang. Een maximum van 2 karakters is toegestaan..'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {
            if(Ingredient::where('name' , '=', $input['name'])->first())
            {
                return Response::json('Ingredient bestaat al binnen leftovers.');
            }

            $ingredient = new Ingredient($input);
            $ingredient->save();

            return Response::json('Je ingredient werd toegevoegd.');
        } else {
            return Response::json('Foutieve ingave.');
        }


    }

} 