<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class userController1 extends Controller
{
    public function index() { //para la API
        return User::all();
    }
    

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
        //auth()->login($user);
        Auth::guard('web')->login($user);
        Log::info('User logged in',  ['veterinaria' => $user]);
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

    //showPets
    public function showPets()
    {
        try {
            $user = Auth::guard('api')->user();
            
            // Check if the user is authenticated
            if (!$user) {
                return response()->json(['error' => 'No autenticado'], 401);
            }
    
            // Check if the relationship exists
            if (!$user->usersCoolPets) {
                return response()->json(['error' => 'No se encontraron mascotas'], 404);
            }
    
            // Return the user's cool pets
            return $user->usersCoolPets()->latest()->get();
        } catch (JWTException $e) {
            return response()->json(['error' => 'No autenticado'], 401);
        }
    }


}
