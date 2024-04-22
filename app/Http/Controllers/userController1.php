<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class userController1 extends Controller
{
    /*
    public function __construct() {
        $this->middleware('auth.user')->only(['logout']);
    }
    */

    public function register(Request $request) {
        
        $incomingFields = $request->validate([
            'id' => ['required', 'numeric', Rule::unique('users', 'id')],
            'nombre' => ['required', 'min:3', 'max:10'],
            'email' => ['min:3', 'email', Rule::unique('users', 'email') ],//'email:rfc,dns'],
            'telf' => ['required', 'numeric', 'digits_between:6,12'], // Phone number validation rules
            'password' => ['required', 'min:8']
        ]);

        Log::info('User validation passed', $incomingFields);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        
        foreach ($incomingFields as $key => $value) {
            $incomingFields[$key] = strip_tags($value);
        }
        
        $user = User::create($incomingFields);
        Log::info('User created', ['veterinaria' => $user]);
        auth()->login($user);
        Log::info('User lgged in',  ['veterinaria' => $user]);
        return redirect('/');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginid' => ['required'],
            'loginpassword' => ['required']
        ]);

        if(auth()->attempt(['id' => $incomingFields['loginid'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
        }
        return redirect('/');
    }
}
