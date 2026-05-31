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
}