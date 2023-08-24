<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show register/create form
    public function create() {
        // Rendering resources/views/users/register.blade.php, the second argument for passing data to corresponding accessed file
        return view('users.register');
    }

    // Show register/create form
    public function store(Request $request) {

        // Validating the all value store in $request, all validation rule store in an array
        $formFields = $request->validate([
            // min:3: 3 letter minimum
            'name' => ['required', 'min:3'],
            // Rule::unique('DB name', 'column_name'): only accept unique value
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            // 'confirmed' use for checking two input field (in this case: 'password' and 'confirm_password'), min:6: 6 letter minimum
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create and store it in database by "User" model, :: is a static method
        $user = User::create($formFields);

        // auth(): authenticate user, login and carrying value inside $user session
        auth()->login($user);

        // redirect to '/' file with flash message
        return redirect('/')->with('message', 'User created and logged in');
    }

    // Logout user
    public function logout(Request $request) {
        
        //auth()->logout(): remove the authentication information from respective session (in this case: $user session)
        auth()->logout();

        // invalidate session
        $request->session()->invalidate();

        // regenerate 'csrf' token
        $request->session()->regenerateToken();

        // redirect to '/' file with flash message
        return redirect('/')->with('message', 'You have been logged out!');
    }

    // Show login form
    public function login() {
        // Rendering resources/views/users/login.blade.php, the second argument for passing data to corresponding accessed file
        return view('users.login');
    }

    // Authenticate user
    public function authenticate(Request $request) {
        // Validating the all value store in $request, all validation rule store in an array
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {

            // regenerate session
            $request->session()->regenerate();

            // redirect to '/' file with flash message
            return redirect('/')->with('message', 'You are now logged in!');
        }

        // back(): redirect to current file with withError(): general flash message (in this case: resources/views/users/login.blade.php)
        return back()->withErrors(['email' => 'Invalid Credential'])->onlyInput('email');
    }
}