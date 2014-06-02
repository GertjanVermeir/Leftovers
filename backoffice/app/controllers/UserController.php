<?php

class UserController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if( strpos(Route::getCurrentRoute()->getPath(), 'admin') !== false)
        {
            return View::make('admin.user.index');
        }

        return View::make('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if( strpos(Route::getCurrentRoute()->getPath(), 'admin') !== false)
        {
            return View::make('admin.user.create')->with('user');
        }

        return View::make('user.create');
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
            'email' => 'required|email',
            'password' => 'required',
            'password_repeated' => 'required|same:password',
            'givenname' => 'required|min:2|max:45',
            'surname' => 'required|min:2|max:45',
            'picture' => 'image',
            'role' => 'required',
            'birthday' => 'required',
        ];

        $messages = [
            'required' => 'Vul :attribute in.',
            'min' => ':attribute is te kort short. Een minimum van 2 karakters is verplicht.',
            'max' => ':attribute is te lang. Een maximum van 2 karakters is toegestaan.',
            'email' => 'Gelieve een geldig e-mailadres in te vullen.',
            'same' => ':attribute'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {
            $user = new User();
            $user->password = $input['password'];
            $user->role = $input['role'];
            $user->surname = $input['surname'];
            $user->givenname = $input['givenname'];

            if(isset($input['blacklist']))
            {
                $user->blacklist = 1;
            }
            else{
                $user->blacklist = 0;
            }

            if(isset($input['chef']))
            {
                $user->chef = 1;
            }
            else{
                $user->chef = 0;
            }

            $user->birthday = $input['birthday'];

            if(User::where('email' , '=', $input['email'])->first())
            {
                return Redirect::route('admin.user.create')->withErrors('Gebruiker met e-mailadres bestaat al.')->withInput();
            }

            $user->email = $input['email'];

            if (Input::hasFile('picture')) {
                $file            = Input::file('picture');
                $root            = public_path();
                $destinationPath = $root.'/images/';
                $filename        = str_random(6) . '_' . $file->getClientOriginalName();
                $uploadSuccess   = $file->move($destinationPath, $filename);

                $user->picture = $filename;
            }

            $user->save();

            if( strpos(Route::getCurrentRoute()->getPath(), 'admin') !== false)
            {
                return Redirect::route('admin.user.index')->with('success', 'De gebruiker: '.$user['givenname'].'" werd toegevoegd!');
            }

            return Redirect::route('admin.user.index');
            //
        } else {
            if( strpos(Route::getCurrentRoute()->getPath(), 'admin') !== false)
            {
                return Redirect::route('admin.user.create')->withErrors($validator)->withInput();
            }
            return Redirect::route('user.create')->withErrors($validator)->withInput();
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
        $user = User::find($id);
        return View::make('admin.user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return View::make('admin.user.edit')->with('user', $user);
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
            'givenname' => 'required|min:2|max:45',
            'surname' => 'required|min:2|max:45',
            'role' => 'required',
            'birthday' => 'required',
        ];

        $messages = [
            'required' => 'Vul :attribute in.',
            'min' => ':attribute is te kort short. Een minimum van 2 karakters is verplicht.',
            'max' => ':attribute is te lang. Een maximum van 2 karakters is toegestaan.',
            'email' => 'Gelieve een geldig e-mailadres in te vullen.',
            'same' => ':attribute'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->passes()) {
            $user = User::find($id);

            $user->role = $input['role'];
            $user->surname = $input['surname'];
            $user->givenname = $input['givenname'];

            if(isset($input['blacklist']))
            {
                $user->blacklist = 1;
            }
            else{
                $user->blacklist = 0;
            }

            if(isset($input['chef']))
            {
                $user->chef = 1;
            }
            else{
                $user->chef = 0;
            }

            $user->birthday = $input['birthday'];

            if (Input::hasFile('picture')) {
                $file            = Input::file('picture');
                $root            = public_path();
                $destinationPath = $root.'/images/';
                $filename        = str_random(6) . '_' . $file->getClientOriginalName();
                $uploadSuccess   = $file->move($destinationPath, $filename);
                File::delete(public_path().'/images/'.$user->picture);

                $user->picture = $filename;
            }

            $user->save();

            return Redirect::route('admin.user.index')->with('success', 'Gebruiker: "'.$user['givenname'].'" werd aangepast !');

        } else {
            return Redirect::route('admin.user.edit', $id)->withErrors($validator)->withInput();
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
        $user = User::find($id);

        $user->delete();

        return Redirect::route('admin.user.index')->with('success', 'Success deleting the user "'.$user['givenname'].'" !' );
    }

    public function auth()
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) {
            $credentials = [
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            ];

            if (Auth::attempt($credentials)) {
                // once authorized, return to this route:
                return Redirect::route('UberIndex');
            } else {
                return Redirect::route('user.login')->withErrors($validator)->withInput();
            }
        } else {
            return Redirect::route('user.login')->withErrors($validator)->withInput();
        }
    }
}