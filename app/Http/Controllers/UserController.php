<?php

namespace App\Http\Controllers;

use App\Item;
use App\User;
use App\Utility\Utils;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view("users.users-index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user  = User::all()->where('slug', $slug)->first();

//        dd($user);
        return view('users.users-form',
            [
                'user' => $user
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {


        $user = User::all()->where('slug', $slug)->first();

        if(!Utils::canUpdateUser($user)){
           return redirect('/')->with('status', 'Not allowed !');;
        }

        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone_number' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->phone_number = $request['phone_number'];
        $user->password = bcrypt($request['password']);
        $user->slug = str_slug($request['first_name']." ". $request['last_name']." ".random_int(1000,9000));

        $user->save();

        return redirect('/')->with('status', 'The profile has been updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        if(!Utils::isSuperAdmin()){
            return redirect('/')->with('status', 'Cannot delete ! Not Allowed ');
        }

        $user = User::all()->where('slug', $slug)->first();

        $items = Item::all()->where('owned_by', $user->id);

        dd($items);

        foreach ($items as $item){
            $item->delete();
        }

        $user->delete();

        return redirect('/users')->with('status', 'User was deleted successfully !');
    }
}
