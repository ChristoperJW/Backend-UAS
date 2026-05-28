<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class LoginController extends Controller
{
    // Show the login form
    public function index()
    {
        return view('login'); 
    }

    // Process the login
    public function login(Request $request)
    {
        // 2. Add password to the validation requirements
        $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);

        $user = User::where('email', $request->email)->first();

        // 3. Check if the user exists AND if the hashed password matches
        if ($user && Hash::check($request->password, $user->password)) {
            
            session(['current_user_id' => $user->id]);
            return redirect('/'); 
        }

        // 4. Return a generic error message (don't tell them which one was wrong!)
        return back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('current_user_id');
        return redirect('/login');
    }
}