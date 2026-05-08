<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class UserController extends Controller
{
    // User list
    public function users()
    {
        return view('users.index');
    }

    // Yajra DataTable
    public function getUsers()
    {
        $users = User::with('roles');
        return DataTables::of($users)
            ->addColumn('role', function($user) {
                return $user->getRoleNames()->implode(', ') ?: 'No Role';
            })
            ->addColumn('action', function($user) {
                return '
                    <a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Change Role</a>
                ';
            })
            ->rawColumns(['action', 'role'])
            ->make(true);
    }

    // Edit user role page
    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update user role
    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles($request->role);
        return redirect()->route('users.index');
    }
}