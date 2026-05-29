<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
    public function deleteAccount(Request $request)
    {
        // 1. Get the securely stored ID of the person making the request
        $currentUserId = session('current_user_id');

        // 2. Find them in the database
        $user = \App\Models\User::find($currentUserId);

        if ($user) {
            // 3. Delete the account from the database
            $user->delete();

            // 4. Destroy their session so they are instantly logged out
            $request->session()->forget('current_user_id');

            // 5. Send them back to the login page with a goodbye message
            return redirect('/login')->with('success', 'Your account has been deleted.');
        }

        // Fallback just in case
        return redirect('/')->with('error', 'Something went wrong.');
    }
}