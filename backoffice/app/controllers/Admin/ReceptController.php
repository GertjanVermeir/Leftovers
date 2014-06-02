<?php

class Admin_ReceptController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('admin.recipe.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.recipe.create');
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
        $input = Input::all();
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
        ];

        $messages = [
            'required' => 'Vul :attribute in.',
            'min' => ':attribute is te kort short. Een minimum van 2 karakters is verplicht.',
            'max' => ':attribute is te lang. Een maximum van 2 karakters is toegestaan.',
            'integer' => 'Vul all :attributes in.'
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

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {

            $recipe = new Recipe($input);

            if($amountCheck == false || $ingredientCheck == false)
            {
                return Redirect::route('admin.recipe.create')->with('ingerror','Vul de ingredienten met hun aantal in.')->withInput();
            }

            if (Input::hasFile('mainimage')) {
                $file            = Input::file('mainimage');
                $root            = public_path();
                $destinationPath = $root.'/images/users/';
                $filename        = str_random(6) . '_' . $file->getClientOriginalName();
                $uploadSuccess   = $file->move($destinationPath, $filename);
                $recipe->image = $filename;

            }

            $recipe->description = $input['description'];
            $recipe->time = $input['time'];
            $recipe->level = $input['level'];
            $recipe->course = $input['course'];
            $recipe->persons = $input['persons'];
            $recipe->type = $input['type'];
            $recipe->user_id = Auth::user()->id;
            $recipe->save();

            foreach($ingredients as $key => $ingredient)
            {
                $amount = $amounts[$key];
                $recipe->ingredients()->attach($ingredient,array('amount' => $amount ));
            }

            return Redirect::route('admin.recipe.index')->with('success', '"'.$recipe['name'].'" werd toegevoegd !');
        } else {
            return Redirect::route('admin.recipe.create')->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $recipe = Recipe::findOrFail($id);

        return View::make('admin.recipe.show')->with('recipe', $recipe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);

        if (Auth::user()->id != $recipe->user->id || Auth::user()->role != 'Administrator') return View::make('noentrance');

        return View::make('admin.recipe.edit')->with('recipe', $recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $ingredientCheck = true;
        $amountCheck = true;
        $input = Input::all();
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
            'mainimage' => 'image',
        ];

        $messages = [
            'required' => 'Vul :attribute in.',
            'min' => ':attribute is te kort short. Een minimum van 2 karakters is verplicht.',
            'max' => ':attribute is te lang. Een maximum van 2 karakters is toegestaan.',
            'integer' => 'Vul all :attributes in.'
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

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {

            if($amountCheck == false || $ingredientCheck == false)
            {
                return Redirect::route('admin.recipe.create')->with('ingerror','Vul de ingredienten met hun aantal in.')->withInput();
            }

            $recipe = Recipe::findOrFail($id);

            if (Input::hasFile('mainimage')) {
                $file            = Input::file('mainimage');
                $root            = public_path();
                $destinationPath = $root.'/images/';
                $filename        = str_random(6) . '_' . $file->getClientOriginalName();
                $uploadSuccess   = $file->move($destinationPath, $filename);

                File::delete(public_path().'/images/'.$recipe->image);
                $recipe->image = $filename;
            }


            $recipe->user_id = Auth::user()->id;
            $recipe->description = $input['description'];
            $recipe->time = $input['time'];
            $recipe->level = $input['level'];
            $recipe->course = $input['course'];
            $recipe->type = $input['type'];
            $recipe->persons = $input['persons'];
            $recipe->user_id = Auth::user()->id;
            $recipe->save();

            $recipe->ingredients()->detach();

            foreach($ingredients as $key => $ingredient)
            {
                $amount = $amounts[$key];
                $recipe->ingredients()->attach($ingredient,array('amount' => $amount ));
            }

            return Redirect::route('admin.recipe.index')->with('success', '"'.$recipe['name'].'" werd aangepast !');
        } else {
            return Redirect::route('admin.recipe.edit', $id)->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);

        if (Auth::user()->id != $recipe->user->id || Auth::user()->role != 'Administrator') return View::make('noentrance');

        $recipe->delete();

        return Redirect::route('admin.recipe.index')->with('success', '"'.$recipe['name'].'" werd verwijderd!' );
    }

}