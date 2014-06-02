<?php

class Admin_IngredientController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('admin.ingredient.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.ingredient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

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
                return Redirect::route('admin.ingredient.create')->withErrors('Ingredient bestaat al.')->withInput();
            }

            $ingredient = new Ingredient($input);
            $ingredient->save();

            return Redirect::route('admin.ingredient.index')->with('success', '"'.$ingredient['name'].'" werd toegevoegd !');
        } else {
            return Redirect::route('admin.ingredient.create')->withErrors($validator)->withInput();
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
        $ingredient = Ingredient::findOrFail($id);
        return View::make('admin.ingredient.show')->with('ingredient', $ingredient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $ingredient = Ingredient::findOrFail($id);

        if (Auth::user()->role !== 'Administrator') return View::make('noentrance');

        return View::make('admin.ingredient.edit')->with('ingredient', $ingredient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

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
            'max' => ':attribute is te lang. Een maximum van 2 karakters is toegestaan.'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {
            $ingredient = Ingredient::findOrFail($id);

            $ingredient->name = $input['name'];
            $ingredient->description = $input['description'];
            $ingredient->calories = $input['calories'];
            $ingredient->unit = $input['unit'];
            $ingredient->type = $input['type'];

            $ingredient->save();

            return Redirect::route('admin.ingredient.index')->with('success', '"'.$ingredient['name'].'" werd gewijzigd !');
        } else {
            return Redirect::route('admin.ingredient.edit', $id)->withErrors($validator)->withInput();
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
        $ingredient = Ingredient::findOrFail($id);

        if (Auth::user()->role !== 'Administrator') return View::make('noentrance');

        $ingredient->delete();

        return Redirect::route('admin.ingredient.index')->with('success', '"'.$ingredient['name'].'" werd verwijderd!' );
    }

}