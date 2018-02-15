<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');

        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function store(UserStoreRequest $request)
    {
        $profile = new UserProfile();
        $user    = new User();
        $user->fill($request->except(['_token', 'role_id']));
        $user->save();
        $user->profile()->save($profile);
        $user->assignRole($request->get('role_id'));

        return redirect()->route('admin.user.index')->with('alert', [
            'alert'   => 'success',
            'message' => 'Data User Berhasil Disimpan !'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  User  $user
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->fill($request->except('_token', '_method'));
        $user->save();

        return redirect()->route('admin.user.index')->with('alert', [
            'alert'   => 'success',
            'message' => 'Data User Berhasil Diperbarui !'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = User::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.user.index')->with('alert', [
            'alert'   => 'success',
            'message' => 'Data User Berhasil Dihapus !'
        ]);

    }
}
