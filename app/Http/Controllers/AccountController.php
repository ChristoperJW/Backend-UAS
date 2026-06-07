<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
    public function deleteAccount(Request $request)
    {
        $currentUserId = session('current_user_id');
        $user = \App\Models\User::find($currentUserId);

        if ($user) {
            $user->delete();
            $request->session()->forget('current_user_id');
            return redirect('/login')->with('success', 'Your account has been deleted.');
        }
        return redirect('/')->with('error', 'Something went wrong.');
    }

    public function updateAccount(Request $request)
    {
        $currentUserId = session('current_user_id');
        $user = \App\Models\User::find($currentUserId);

        if ($user) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:4'
            ]);

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect('/account')->with('success', 'Account updated successfully!');
        }
        return redirect('/account')->with('error', 'Something went wrong.');
    }
}