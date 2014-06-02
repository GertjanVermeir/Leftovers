<?php

class Admin_RoleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('admin.role.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.role.create');
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
        ];

        $messages = [
            'required' => 'Please fill in the role :attribute.',
            'min' => 'Role :attribute is to short. A minimum of 2 characters is required.',
            'max' => 'Role :attribute is to long. A maximum of 45 characters is allowed.'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {
            $role = new Role($input);
            $role->save();

            return Redirect::route('admin.role.index')->with('success', 'Success adding the role "'.$role['name'].'" !');
        } else {
            return Redirect::route('admin.role.create')->withErrors($validator)->withInput();
        }

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $role = Role::find($id);
		return View::make('admin.role.edit')->with('role', $role);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	    $input = Input::all();

        $rules = [
            'name' => 'required|min:2|max:45',
        ];

        $messages = [
            'required' => 'Please fill in the role :attribute.',
            'min' => 'Role :attribute is to short. A minimum of 2 characters is required.',
            'max' => 'Role :attribute is to long. A maximum of 45 characters is allowed.'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {
            // rol ophalen
            $role = Role::find($id);

            // nieuwe waarden ingeven
            $role->name = $input['name'];
            $role->description = $input['description'];

            // opslaan
            $role->save();

            return Redirect::route('admin.role.index')->with('success', 'Success updating the role "'.$role['name'].'" !');
        } else {
            return Redirect::route('admin.role.edit', $id)->withErrors($validator)->withInput();

        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$role = Role::find($id);

        $role->delete();

        return Redirect::route('admin.role.index')->with('success', 'Success deleting the role "'.$role['name'].'" !' );;
	}

}