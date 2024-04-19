<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class userController1 extends Controller
{
    /*
    public function __construct() {
        $this->middleware('auth.user')->only(['logout']);
    }
    */

    public function register(Request $request) {
        
        $incomingFields = $request->validate([
            'nombre' => ['required', 'min:3', 'max:10'],
            'email' => ['min:3', 'email', Rule::unique('users', 'email') ],//'email:rfc,dns'],
            'telf' => ['required', 'numeric', 'digits_between:6,12'], // Phone number validation rules
            'password' => ['required', 'min:8']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        
        foreach ($incomingFields as $key => $value) {
            $incomingFields[$key] = strip_tags($value);
        }
        
        $user = User::create($incomingFields);
        auth()->login($user);
        echo "'rgistering controllar says haiii :3'";
        return redirect('/');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginname' => ['required'],
            'loginpassword' => ['required']
        ]);

        if(auth()->attempt(['nombre' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
        }
        return redirect('/');
    }
}
