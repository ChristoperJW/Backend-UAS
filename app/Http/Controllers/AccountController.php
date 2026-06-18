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

    public function indexUpdate()
    {
        return view('updateacc');
    }


    public function updateAccount(Request $request)
    {
        $currentUserId = session('current_user_id');
        $user = \App\Models\User::find($currentUserId);

        if ($user) {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'old_password' => 'required|min:4',
                'new_password' => 'required|min:4',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->new_password) {
                if (!Hash::check($request->old_password, $user->password)) {
                    return back()->with('error', 'The provided password does not match your current password.');
                }
                $user->password = Hash::make($request->new_password);
            }

            if ($request->old_password == $request->new_password) {
                return back()->with('error', 'New password cannot be the same as the current password.');
            }

            $user->save();

            return redirect('/account')->with('success', 'Account updated successfully!');
        }
        return redirect('/account')->with('error', 'Something went wrong.');
    }

    public function updatePrivacy(Request $request)
    {
        $currentUserId = session('current_user_id');

        $user = User::find($currentUserId);

        if (!$user) {
            return redirect('/login')->with('error', 'Please log in first.');
        }

        $user->require_follow_approval = $request->has('require_follow_approval');
        $user->is_private = $request->has('is_private');
        $user->save();

        return redirect('/account')->with('success', 'Privacy setting updated successfully.');
    }
}