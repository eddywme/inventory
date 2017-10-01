<?php

namespace App\Http\Controllers;

use App\Item;

use App\Role;
use App\User;
use App\Utility\RoleUtils;
use App\Utility\Utils;
use Illuminate\Http\Request;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (!RoleUtils::isSystemPersonnel()) {
			return redirect('/');
		}

		$users = User::all();

		return view("users.users-index", ["users" => $users]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($slug) {
		$user = User::all()->where('slug', $slug)->first();

		if (!Utils::canUpdateUser($user)) {
			return redirect('/')->with('status', 'Not allowed !');
		}

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
	public function update(Request $request, $slug) {

		$user = User::all()->where('slug', $slug)->first();

		if (!Utils::canUpdateUser($user)) {
			return redirect('/')->with('status', 'Not allowed !');
		}

		$this->validate($request, [
				'first_name'   => 'required|string|max:255',
				'last_name'    => 'required|string|max:255',
				'email'        => 'required|string|email|max:255|unique:users,email,'.$user->id,
				'phone_number' => 'required|string|unique:users,phone_number,'.$user->id,
				'password'     => 'required|string|min:6|confirmed',
			]);

		$user->first_name   = $request['first_name'];
		$user->last_name    = $request['last_name'];
		$user->email        = $request['email'];
		$user->phone_number = $request['phone_number'];
		$user->password     = bcrypt($request['password']);

		$user->save();

		return redirect()->back()->with('success-status', 'The profile has been updated successfully !');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($slug) {
		if (!RoleUtils::isSysAdmin()) {
			return redirect('/')->with('status', 'Cannot delete ! Not Allowed ');
		}

		$user = User::all()->where('slug', $slug)->first();

		$items = Item::all()->where('owned_by', $user->id);

		dd($items);

		foreach ($items as $item) {
			$item->delete();
		}

		$user->delete();

		return redirect(route('items.index'))->with('status', 'User was deleted successfully !');
	}

	public function manageRolesIndex () {
        if (!RoleUtils::isSysAdminOrManager()) {
            return redirect('/')->with('status', 'Not Allowed ');
        }
        $users = User::all();

        $roles = Role::all();

        if(RoleUtils::isManager()) {
            /* Managers can only assign managerial roles and below  */
            $roles = Role::all()->filter(function ($role) {
                return $role->name !== "sys-admin-user";
            });
        }


        return view("users.manage-roles-index", [
            "users" => $users,
            "roles" => $roles,
        ]);
    }

    public function assignRole (Request $request) {
        if (!RoleUtils::isSysAdminOrManager()) {
            return redirect('/')->with('status', 'Not Allowed ');
        }

        $this->validate($request, [
            'role'   => 'required|integer',
            'email'   => 'required|email',
        ]);

        $user = User::all()->where('email', $request->get('email'))->first();

        if($user === null) {
            return redirect()->back()->with('error-status', 'The User does not exist in the System !');
        }

	    $roleId = $request->get('role');

        $role = Role::where('id', $roleId)->first();

        if($role === null) {
            return redirect()->back()->with('error-status', 'The Role does not exist in the System !');
        }

        /* When user tries ID tricks to submits roles abilities he's not allowed to assign // Redirect Back */
        if(RoleUtils::isManager() && $role->name == "sys-admin-user") {
           return redirect()->back()->with("error-status", "Not Allowed");
        }


        $user->role_id = $roleId;
        $user->save();
        return redirect(route('users.index'))->with('success-status', 'The role was assigned successfully to the user !');


    }

}
