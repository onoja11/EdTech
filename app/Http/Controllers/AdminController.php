<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function allUsers(){
        $users = User::all();
        return Inertia('Admin/users', [
            'users' => $users,
        ]);
    }
    public function editShow(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return Inertia('Admin/editUser', [
            'user' => $user,
            // 'user_roles' => $request->input('user_roles'),
        ]);
    }

 public function edit(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'user_roles' => 'required|string',
        'level' => 'required|string',
        'department' => 'required|string'
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'level' => $request->input('level'),
        'department' => $request->input('department'),
        'user_roles' => $request->input('user_roles'),
    ]);

    return redirect()->route('users.all')->with('success', 'User updated successfully.');
}

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.all')->with('success', 'User deleted successfully.');
    }
}
